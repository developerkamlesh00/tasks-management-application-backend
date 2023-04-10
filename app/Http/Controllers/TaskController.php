<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_tasks()
    {
        $tasks=Task::all();
        return $tasks;
    }
    public function worker_tasks($id)
    {
        $tasks=Task::where('worker_id',$id)->get();
        return $tasks;
    }
    public function project_tasks($id)
    {
        $tasks=Task::where('project_id',$id)->get();
        return $tasks;
    }
    public function worker_project_tasks($worker_id,$project_id)
    {
        $tasks=Task::where('worker_id',$worker_id)->where('project_id',$project_id)->get();
        return $tasks;
    }
    public function update_status($task_id,$status_id)
    {   
        $task=Task::findOrFail($task_id);
        if (0<=$status_id && $status_id<=4){
            $task->status_id=$status_id;
            if($status_id==4){
                $task->completed_at=now();
            }
            $task->save();
            return 'Success';
        };
        return 'Failure';
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}