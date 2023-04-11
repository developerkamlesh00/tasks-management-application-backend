<?php

namespace App\Http\Controllers;

// use App\Events\UserCreated as EventsUserCreated;
use App\Mail\UserCreated;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'organization_id' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $input = $request->all();
        $temppass = $input['password'];
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        //return $user;
        Mail::to($user)->queue(new UserCreated($user,$temppass)); //for email sending

        $resposeArray = [];
        $resposeArray['token'] = $user->createToken('UserToken')->accessToken;
        $resposeArray['name'] = $user->name;

        return response()->json($resposeArray, 200);
    }


    //login handler
    public function login(Request $request)
    {
        //return response()->json($request);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $resposeArray = [];
            $resposeArray['token'] = $user->createToken('UserToken')->accessToken;
            $resposeArray['name'] = $user->name;
            $resposeArray['role'] = $user->role->role_name;
            $resposeArray['userId'] = $user->id;
            $resposeArray['organization_id'] = $user->organization_id;
            return response()->json($resposeArray, 200);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 203);
        }
    }


    public function managers($org){
        $user = User::where('role_id','=',3)->where("organization_id","=",$org)->get();
        return response()->json($user);
    }
    // public function getProjects($org){
    //     return Project::with('user')->where("organization_id","=",$org)->get();
    // }

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
        //
    }
}
