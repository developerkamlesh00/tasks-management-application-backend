<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class ManagerController extends Controller
{
    public function projects(Request $request){
   
       $managerId= $request->query('manager');
       $projects=Project::all()->where('manager_id', $managerId);
       return $projects;
    }

    public function workers(Request $request){
        $managerId= $request->query('manager'); 

        $organisationId = DB::table('users')->where('id', $managerId)->value('organization_id'); 
    
        $workers = User::all()->where('role_id', '4')->where('organization_id', $organisationId); 
        return $workers;
    }

    public function single_project(Request $request){
        $project_id = $request->query('id');

        $project = DB::table('projects')->where('id', $project_id)->get();
        //$project = Project::where('id', $project_id)->first();

        return $project;    
    }


    public function update_project_tasks(Request $request){
        

        $project = Project::find($request->id);
        $total_tasks = Task::all()->where('project_id', $request->id)->count();
        $completed_tasks = Task::all()->where('project_id', $request->id)->where('status_id', 4)->count();
      
        $project['total_tasks']= $total_tasks;
        $project['tasks_completed']= $completed_tasks;

        $result = $project->save();
        

        if($result){
            return ["status"=> "Your tasks have been updated"];
        }
        else{
            return ["status"=> "operation failed"];
        }
    }

    public function single_worker(Request $request){
        $worker_id = $request->query('id');

        $worker = DB::table('users')->where('id', $worker_id)->get();
        return $worker;    
    }

    public function get_assigned_tasks(Request $request){
       $id= $request->id;
        $assigned_tasks=DB::table('tasks')->where('worker_id', $id)->get();
        return $assigned_tasks;

    }

    public function tasks(Request $request){
        $project_id = $request->query('id');
        
        $tasks = DB::table('tasks')->where('project_id', $project_id)->get();
      
       foreach ($tasks as $task) {
            $task->worker_id = User::where('id',$task->worker_id)->value('name');
        }

        return $tasks;        
    }

    public function add_task(Request $request){

        $validation=Validator::make($request->all(),[
            'title'=>'required|min:5|max:30',
            'description'=>'required|min:5|max:30',
            'assigned_at'=>'required',
            'estimated_deadline'=>'required',
            'worker_id'=>'required',
       ]);

       if($validation){;
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

        $project = Project::find($request->projectId);
        $project['total_tasks'] = $project['total_tasks']+1;

        $result2=$project->save();
       
        if($result && $result2){
            return ["status"=> "Your data has been saved"];
        }
        else{
            return ["status"=> "operation failed"];
        }
    }
    else{
        return ["status"=> "operation failed"];
    }

    }

        public function edit_task(Request $request){
           $validation=Validator::make($request->all(),[
                'title'=>'required|min:5|max:30',
                'description'=>'required|min:5|max:30',
                'assigned_at'=>'required',
                'estimated_deadline'=>'required',
                'worker_id'=>'required',
           ]);
            //return $request->id;
            if($validation){
                $task = Task::find($request->id);
                $task['title'] = $request->title;
                $task['description'] = $request->description;
                $task['worker_id'] = $request->workerId;
                $task['assigned_at'] = $request->assignedDate;
                $task['estimated_deadline'] = $request->estimatedDeadline;
                $task['review_passed'] = 0;
    
                $result = $task->save();    
            }
            else {
                return ["status"=> "Task failed"];
            }

        if($result){
            return ["status"=> "Your data has been updated"];
        }
        else{
            return ["status"=> "operation failed"];
        }


    }
    public function delete_task($id){
        $comments = Comment::where('task_id', $id)->delete();
        $task=Task::find($id);
        $result =$task->delete();

        if($result){
            return ["status"=> "The task has been deleted"];
        }
        else{
            return ["status"=> "operation failed"];
        }
    }

   

    public function review_task(Request $request){
       
        $manager_id= $request->id;
        $assigned_projects=Project::all()->where('manager_id', $manager_id); 
        $assigned_tasks=[];
        foreach($assigned_projects as $assigned_project){
            $assigned_temp_tasks=Task::all()->where('project_id', $assigned_project->id)->where('status_id',3);
            $assigned_tasks[]=array($assigned_temp_tasks);
        }
       
        return $assigned_tasks;
    }

    public function approve_task(Request $request){
        $project=Project::find($request->projId);
        $task = Task::find($request->id);

        $task['status_id']=4;
        $task['review_passed']=1;

        $result = $task->save();

        $total_tasks = Task::all()->where('project_id', $request->projId)->count();
        $completed_tasks = Task::all()->where('project_id', $request->projId)->where('status_id', 4)->count();

        if($total_tasks === $completed_tasks){
            $project['completed_at'] = date('Y-m-d H-i-s');
            $project->save();
        }
     

        if($result){
            return ["status"=>"task approved successfully"];
        }
        else{
            return ["status"=>"operation failed"];
        }


    } 
    public function reject_task(Request $request){
        $task = Task::find($request->id);

        $task['status_id']=1;

        $result = $task->save();

        if($result){
            return ["status"=>"task rejected successfully"];
        }
        else{
            return ["status"=>"operation failed"];
        }
    }
    
    public function worker_names(Request $request){
       
        $organisation_id = User::where('id',$request->id)->value('organization_id');
      
        
        $worker_names = User::select('id','name')->where('organization_id',$organisation_id)->where('role_id', 4)->get();
        return $worker_names;
    }

    public function toggle_visibility(Request $request){
     
        $project=Project::find($request->id);
        
        if($project['workers_visibility']==1){
            $project['workers_visibility']=0;
        }
        else{
            $project['workers_visibility']=1;
        }

        $result=$project->save();

        if($result){
            return $project['workers_visibility'];
            
        }else{
            return ["status"=>"operation failed"];
        }
    }
}