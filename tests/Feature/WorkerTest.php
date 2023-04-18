<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use app\Models\User;
class WorkerTest extends TestCase
{
    use RefreshDatabase;

    // Set header function for api auth 
    // Fill header with auth token
    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];
        if (!is_null($user)) {
            $token = $user->createToken('Token Name')->accessToken;
            $headers['Authorization'] = 'Bearer ' . $token;
        }
        return $headers;
    }

    // Worker Login
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

    // Get all tasks assigned to a worker
    public function test_get_tasks(){
        $user = User::find(4);
        $response = $this->get("/api/worker/$user->id/tasks",$this->headers($user));
        $response->assertStatus(200);
    }

    // Get all tasks assigned to a worker in a specific project
    public function test_get_project_tasks(){
        $user = User::find(4);
        $task = Task::where('worker_id',$user->id)->first();
        $response = $this->get("/api/worker/$user->id/project/$task->project_id/tasks",$this->headers($user));
        $response->assertStatus(200);
    }

    // Get all projects on which worker is working on
    public function test_worker_projects(){
        $user = User::find(4);
        $response = $this->get("/api/worker/$user->id/project",$this->headers($user));
        $response->assertStatus(200);
    }

    // Get all comments on a task GET
    public function test_task_comments(){
        $user = User::find(4);
        $task = Task::where('worker_id',$user->id)->first();
        $response = $this->get("/api/worker/task/$task->id/comments",$this->headers($user));
        $response->assertStatus(200);
    }

    // Create a new comment POST
    public function test_create_comment(){
        $user = User::find(4);
        $task = Task::find(1);
        $response = $this->post("/api/worker/comments",[
            'body' => 'New Comment',
            'user_id' => $user->id,
            'task_id' => $task->id
        ],$this->headers($user));
        $response->assertStatus(201);
    }

    // Edit a comment PUT
    public function test_edit_comment(){
        $user = User::find(4);
        $task = Task::find(1);
        $this->test_create_comment();
        $comment=Comment::find(1);
        $response = $this->put("/api/worker/comments/$comment->id",[
            'body' => 'Edited Comment',
            'user_id' => $user->id,
            'task_id' => $task->id
        ],$this->headers($user));
        $response->assertStatus(200);
    }

    // Delete a comment DELETE
    public function test_delete_comment(){
        $user = User::find(4);
        $task = Task::find(1);
        $this->test_create_comment();
        $comment=Comment::find(1);
        $response = $this->delete("/api/worker/comments/$comment->id",$this->headers($user));
        $response->assertStatus(200);
    }

    // Change status of a task
    public function test_change_task_status(){
        $user = User::find(4);
        $task = Task::find(1);
        $status_id=($task->status_id+1)%4;
        $response = $this->post("/api/worker/update_status/task/$task->id/status/$status_id",[],$this->headers($user));
        $updated_task=Task::findOrFail($task->id);
        $this->assertEquals($updated_task->status_id,$status_id);
    }
}
