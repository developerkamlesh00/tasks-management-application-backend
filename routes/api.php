<?php


use App\Http\Controllers\RegisterOrganization;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register',[UserController::class, 'store']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/login', [UserController::class, 'login'])->name('login'); //if not auth or first login

Route::middleware('auth:api')->get('/testapi', function () {
    return response()->json(['user_status' => 'Valide User']);
});


//register Oraganization end point
Route::post('/orgregister', [RegisterOrganization::class, 'register']);



// For Workers

// Not to be used
Route::get('/tasks',[TaskController::class, 'all_tasks']);

// Get all tasks of a worker (from all projects)
Route::get('/worker/{worker_id}/tasks',[TaskController::class, 'worker_tasks']);

// Get all tasks of a particular project - For a manager
Route::get('/project/{project_id}/tasks',[TaskController::class, 'project_tasks']);

// Get all tasks belonging to one project - For a worker
Route::get('/worker/{worker_id}/project/{project_id}/tasks',[TaskController::class, 'worker_project_tasks']);

// Change Task Status
Route::post('update_status/task/{task_id}/status/{status_id}',[TaskController::class, 'update_status']);