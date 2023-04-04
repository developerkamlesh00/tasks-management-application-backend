<?php

use App\Http\Controllers\AdminController;
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

// Get organizations,directors,managers,workers,all member of organization
Route::get('/admin/organizations',[AdminController::class, 'get_organizations']);
Route::get('/admin/directors',[AdminController::class, 'get_directors']);
Route::get('/admin/managers',[AdminController::class, 'get_managers']);
Route::get('/admin/workers',[AdminController::class, 'get_workers']);
Route::get('/admin/organizations/{id}/members',[AdminController::class, 'get_organization_members']);

//Delete user
Route::post('/admin/users/{id}', [AdminController::class, 'destroy']);
