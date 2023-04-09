<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterOrganization;
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


Route::post('/login', [UserController::class, 'login']);
Route::get('/login', [UserController::class, 'login'])->name('login'); //if not auth or first login

//director section apis calls
Route::post('/orgregister', [RegisterOrganization::class, 'register']);

Route::middleware('auth:api')->prefix('/director')->name('director.')->group(function(){
    Route::get('/managers', [UserController::class, 'managers']);
    Route::get('/projects/{org}', [ProjectController::class, 'getprojects'])->name('getprojects');
    Route::post('register', [UserController::class, 'store']);
    Route::post('createproject', [ProjectController::class,'store'])->name('addproject');
    Route::post('updateproject/{projectid}', [ProjectController::class, 'update'])->name('updateproject');
});
//end director section apis calls