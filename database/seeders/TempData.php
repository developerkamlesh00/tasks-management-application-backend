<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        ]);

        $pass = bcrypt('Admin@123');
        User::create([
            'name' => "Director Kamlesh",
            'email' => 'kamlesh@gmail.com',
            'password' => $pass,
            'organization_id' => 2,
            'role_id' => 2,
        ]);

        User::factory()->count(10)->create(); //10 managers
        User::factory()->count(50)->stateMethod()->create(); //50 workers

        Project::factory()->count(10)->stateMethod(30)->create(); //created 10 Projects

        for($i=1 ; $i<=10; $i++){   
            Task::factory()->count(30)->stateMethod($i)->create(); //created task for each project to 30
        }
    }
}
