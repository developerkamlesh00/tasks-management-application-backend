<?php

namespace Tests\Unit;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_get_projects(){
        $response = $this->get('/api/project');
        $response->assertStatus(200);
    }

    public function test_get_workers(){
        $response = $this->get('/api/worker');
        $response->assertStatus(200);

    }

    public function test_get_single_project(){
        $response = $this->get('/api/single_project');
        $response->assertStatus(200);

    }

    public function test_get_single_worker(){
        $response = $this->get('/api/single_worker');
        $response->assertStatus(200);

    }

    public function test_get_tasks(){
        $response = $this->get('/api/tasks');
        $response->assertStatus(200);

    }

    public function test_user_duplication(){
        $user1=User::make([
            'name'=>'name1',
            'email'=>'name1@gmail.com',
            'password'=>'Admin@123',
            'organization_id'=>1,
            'role_id'=>2
        ]);

        $user2=User::make([
            'name'=>'name2',
            'email'=>'name2@gmail.com',
            'password'=>'Admin@123',
            'organization_id'=>1,
            'role_id'=>2
        ]);

            $this->assertTrue($user1->email!=$user2->email);


        }

/*        public function test_add_task(){
            $response = $this->post('/api/add_task',[
                'title'=> 'title1',
                'description'=> 'desc1',
                'worker_id'=>57,
                'assigned_at'=> '2023-02-06 02:51:43',
                'estimated_deadline'=>'2023-02-22 14:40:25',
                'review_passed'=>0,
                'status_id'=>0,
                'project_id'=>2  

            ]);

            $response->assertRedirect('/api/add_task');
        }*/
}

