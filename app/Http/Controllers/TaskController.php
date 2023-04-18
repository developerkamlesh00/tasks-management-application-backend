<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function worker_tasks($id)
    {
        $tasks = Task::where('worker_id', $id)->get();
        return $tasks;
    }
    public function project_tasks($id)
    {
        $tasks = Task::where('project_id', $id)->get();
        return $tasks;
    }
    public function worker_project_tasks($worker_id, $project_id)
    {   
        $tasks = Task::where('worker_id',$worker_id)->where('project_id', $project_id)->get();
        return $tasks;
    }
    public function worker_projects($worker_id)
    {
        $projects = Project::with('user')->whereHas('tasks', function ($query) use ($worker_id) {
            $query->where('worker_id', $worker_id);
        })->get();
        return $projects;

    }
    public function update_status($task_id, $status_id)
    {
        $task = Task::findOrFail($task_id);
        if (0 <= $status_id && $status_id <= 4) {
            $task->status_id = $status_id;
            if ($status_id == 4) {
                $task->completed_at = now();
            }
            $task->save();
            return response()->json(['message' => "Success"], 202);
        };
        return response()->json(['message' => "Failure"], 400);;
    }
}
