<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
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

    public function add_task(Request $request){
        //return ["Result"=>"data has been saved"];
       //return $request;
        $task = new Task;
       
        $task['title'] = $request->title;
        $task['description'] = $request->description;
        $task['worker_id'] = $request->workerId;
        $task['assigned_at'] = $request->assignedDate;
        $task['estimated_deadline'] = $request->estimatedDeadline;
        $task['review_passed'] = 0;
        $task['status_id'] = 1;
        $task['project_id'] =$request->projectId;
        $result = $task->save();

        if($result){
            return ["status"=> "Your data has been saved"];
        }
        else{
            return ["status"=> "operation failed"];
        }


    }

        public function edit_task(Request $request){
            $task = Task::find($request->id);
            $task['title'] = $request->title;
            $task['description'] = $request->description;
            $task['worker_id'] = $request->workerId;
            $task['assigned_at'] = $request->assignedDate;
            $task['estimated_deadline'] = $request->estimatedDeadline;
            $task['review_passed'] = 0;

            $result = $task->save();


        //return ["Result"=>"data has been saved"];
       //return $request;
        /*$task = new Task;
       
        $task['title'] = $request->title;
        $task['description'] = $request->description;
        $task['worker_id'] = $request->workerId;
        $task['assigned_at'] = $request->assignedDate;
        $task['estimated_deadline'] = $request->estimatedDeadline;
        $task['review_passed'] = 0;
        $task['status_id'] = 1;
        $task['project_id'] =$request->projectId;
        $result = $task->save();
*/
        if($result){
            return ["status"=> "Your data has been updated"];
        }
        else{
            return ["status"=> "operation failed"];
        }


    }
    public function delete_task(Request $request){
       //return $request->id;
        
        $task=Task::find($request->id);
        $result =$task->delete();

        if($result){
            return ["status"=> "The task has been deleted"];
        }
        else{
            return ["status"=> "operation failed"];
        }


    }


}
