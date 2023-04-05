<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_organizations()
    {
        $organizations = Organization::all();
        return $organizations;
    }
    public function get_users()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_directors()
    {
        $directors = DB::table('users')
                    ->where('role_id' , '=', '2')
                    ->get();
        return $directors;
    }

    public function get_managers()
    {
        $managers = DB::table('users')
                    ->where('role_id' , '=', '3')
                    ->get();
        return $managers;
    }

    public function get_workers()
    {
        $workers = DB::table('users')
                    ->where('role_id' , '=', '4')
                    ->get();
        return $workers;
    }

    public function get_organization_members($organization_id)
    {
        $members = DB::table('users')
                ->where('organization_id', '=', $organization_id)
                ->get();
        return $members;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully.']);
    }
}
