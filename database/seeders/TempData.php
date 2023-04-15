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

        User::factory()->count(10)->create(); //10 managers
        User::factory()->count(50)->stateMethod()->create(); //50 workers

        Project::factory()->count(10)->stateMethod(30)->create(); //created 10 Projects

        for($i=1 ; $i<=10; $i++){   
            Task::factory()->count(30)->stateMethod($i)->create(); //created task for each project to 30
        }

        for($task_id=1 ; $task_id<=300; $task_id++){   
            // $worker_id=Task::select('worker_id')->where('id',$task_id)->first();
            // $project_id=Task::select('project_id')->where('id',$task_id)->first();
            // $manager_id=Project::select('manager_id')->where('id',$project_id)->first();
            // Comment::factory()->count(3)->stateMethod1($manager_id)->stateMethod2($task_id)->create(); //created 3 comments by manager for each task 
            // Comment::factory()->count(2)->stateMethod1($worker_id)->stateMethod2($task_id)->create(); //created 2 comments by worker for each task 
            Comment::factory()->count(3)->stateMethod($task_id)->create(); //created 3 comments for each task 
        }

    }
}
