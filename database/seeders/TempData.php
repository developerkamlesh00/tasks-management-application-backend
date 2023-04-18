<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create([
            'org_email' => 'crm@gmail.com',
            'org_name' => 'Recruit CRM',
            'total_projects' => 10,
        ]);

        $pass = bcrypt('Admin@123');

        User::create([
            'name' => "Director",
            'email' => 'director@gmail.com',
            'password' => $pass,
            'organization_id' => 2,
            'role_id' => 2,
        ]);
        

        User::factory()->count(10)->create(); //10 managers
        User::factory()->count(50)->stateMethod()->create(); //50 workers

        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => $pass,
            'organization_id' => 2,
            'role_id' => 3,
        ]);
        
        User::create([
            'name' => 'Worker',
            'email' => 'worker@gmail.com',
            'password' => $pass,
            'organization_id' => 2,
            'role_id' => 4,
        ]);

        $created=now();
        $project = Project::make([
            'title' => 'Project 1',
            'description' => 'Lorem ',
            'assigned_at' => $created,
            'estimated_deadline' => date_add($created,date_interval_create_from_date_string('2 weeks')),
            'organization_id' => 2,
            'manager_id' => 3
        ]);
        $project->save();

        $created=now();
        $task=Task::make([
            'title' =>'Task1',
            'description' =>'Lorem ipsum',
            'assigned_at'=>$created,
            'estimated_deadline'=>date_add($created,date_interval_create_from_date_string('2 weeks')),
            'completed_at'=>null,
            'status_id' => 1,
            'worker_id' => 4,
            'project_id'=> $project->id
        ]);
        $task->save();


        Project::factory()->count(10)->stateMethod(30)->create(); //created 10 Projects

        for($i=1 ; $i<=10; $i++){   
            Task::factory()->count(30)->stateMethod($i)->create(); //created task for each project to 30
        }

        for($task_id=1 ; $task_id<=300; $task_id++){   
            // $worker_id=Task::select('worker_id')->where('id',$task_id)->first();
            // $project_id=Task::select('project_id')->where('id',$task_id)->get();
            // $manager_id=Project::select('manager_id')->where('id',$project_id)->get();
            // $obj=[$task_id,$manager_id];
            // Comment::factory()->count(3)->stateMethod($obj)->create(); //created 3 comments by manager for each task 
            // Comment::factory()->count(3)->stateMethod($task_id,$worker_id)->create(); //created 3 comments by manager for each task 
            // Comment::factory()->count(3)->stateMethod1($manager_id)->stateMethod2($task_id)->create(); //created 3 comments by manager for each task 
            // Comment::factory()->count(2)->stateMethod1($worker_id)->stateMethod2($task_id)->create(); //created 2 comments by worker for each task 
            Comment::factory()->count(3)->stateMethod($task_id)->create(); //created 3 comments for each task 
        }

    }
}
