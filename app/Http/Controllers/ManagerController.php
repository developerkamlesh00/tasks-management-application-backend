<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function projects(Request $request){
       //return ["name"=>"name1", "dest"=>"dest1"];

       $managerId= $request->query('manager');
       //return $managerId;
       
      $projects=Project::all()->where('manager_id', $managerId);
       return $projects;
    }

    public function workers(Request $request){
        $managerId= $request->query('manager'); //3

        $organisationId = DB::table('users')->where('id', $managerId)->value('organization_id'); //2
    
        $workers = User::all()->where('role_id', '4')->where('organization_id', $organisationId); //
        return $workers;
    }

    public function single_project(Request $request){
        $project_id = $request->query('id');

        $project = DB::table('projects')->where('id', $project_id)->get();
        return $project;    
    }

    public function tasks(Request $request){
        $project_id = $request->query('id');

        $tasks = DB::table('tasks')->where('project_id', $project_id)->get();
        return $tasks;
        
    }
}
