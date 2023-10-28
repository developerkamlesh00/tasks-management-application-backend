<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class ManagerSectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_projects()
    {   
        
        $response = $this->get('api/project',['id'=>3]);
        $response->assertStatus(200);
    }
    public function test_workers()
    {
        $response = $this->get('api/worker',['id'=>3]);
        $response->assertStatus(200);
    }
    public function test_single_project()
    {
        $response = $this->get('api/single_project',['id'=>8]);
        $response->assertStatus(200);
    }
    public function test_single_worker()
    {
        $response = $this->get('api/single_worker',['id'=>5]);
        $response->assertStatus(200);
    }

    public function test_toggle_visibility()
    {
        $response = $this->put('api/toggle_visibility',['id'=>5]);
        $response->assertStatus(200);
    }

    public function test_update_project_tasks()
    {
        $response = $this->put('api/update_project_tasks',['id'=>5]);
        $response->assertStatus(200);
    }

    public function test_tasks()
    {
        $response = $this->get('api/tasks',['id'=>'3']);
        $response->assertStatus(200);
    }

    /*  */

    public function test_add_task()
    {           
                $data = [
                
                    'title'=>'title1',
                    'description'=>'desc1',
                    'assignedDate'=>'2023-02-01 00:00:00',
                    'estimatedDeadline'=>'2023-04-19 07:18:02',
                    'workerId'=>'6',
                    'projectId'=>'3'

                ];
                $response = $this->post('api/add_task',$data);
                $response->assertStatus(200);
    }        

    public function test_edit_task()
    {           
                $data = [
                
                    'title'=>'newtitle',
                    'description'=>'desc1',
                    'assignedDate'=>'2023-02-01 00:00:00',
                    'estimatedDeadline'=>'2023-04-19 07:18:02',
                    'id'=>'6',
                    'workerId'=>'7'
                    

                ];
                $response = $this->put('api/edit_task',$data);
                $response->assertStatus(200);
    }        
}
