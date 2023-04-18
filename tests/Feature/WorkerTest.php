<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $credentials=[
            "email"=>"worker@gmail.com",
            "password"=>"Admin@123"
        ];
        $response = $this->post('api/login',$credentials);
        
        $response->assertStatus(200);
        return $response;
    }
    // public function test_tasks()
    // {
    //     $this->get('api/worker/4/tasks')->assertStatus(200);
    //     return;
    // }
    // public function test_projects()
    // {
    //     $this->get('api/project/1/tasks')->assertStatus(200);
    //     return;
    // }
    // public function test_worker_projects()
    // {
    //     $this->get('api/worker/4/project')->assertStatus(200);
    //     return;
    // }
    // public function test_comments()
    // {
    //     $this->get('api/task/1/comments')->assertStatus(200);
    //     return;
    // }
}
