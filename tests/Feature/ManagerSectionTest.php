<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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


}
