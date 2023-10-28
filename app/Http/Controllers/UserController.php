<?php

namespace App\Http\Controllers;

// use App\Events\UserCreated as EventsUserCreated;

use App\Mail\ForgotPassMail;
use App\Mail\UserCreated;
use App\Models\User;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


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
        Mail::to($user)->queue(new UserCreated($user->name,$user->email,$temppass)); //for email sending

        $resposeArray = [];
        /** @var \App\Models\User $user **/
        $resposeArray['token'] = $user->createToken('UserToken')->accessToken;
        $resposeArray['name'] = $user->name;
        $resposeArray['userId'] = $user->id;

        return response()->json($resposeArray, 200);
    }

    //bulk registration 
    public function bulkregistrations(Request $request){
      try{
          $data = $request->getContent();
          $data_json = json_decode($data, true);
          foreach ($data_json as $user) {
              $insertuser = User::make();
              $insertuser->name = $user['name'];
              $insertuser->email = $user['email'];
              $insertuser->password = bcrypt($user['password']);
              $insertuser->role_id = $user['role_id'];
              $insertuser->organization_id = $user['organization_id'];
              $insertuser->save();
              //Mail::to($user['email'])->queue(new UserCreated($user['name'],$user['email'],$user['password'])); //for email sending
          }
          return response("Done");
      }catch(Exception $e){
        return response("Data Duplicate or may not be formatted....please provide like this 'name,email,password,role'",404);
      }

    }


    //login handler
    public function login(Request $request)
    {
        // return response()->json($request,200);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $resposeArray = [];
             /** @var \App\Models\User $user **/
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

    //forgot request handle
    public function forgot(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $user = User::where('email',$request->email)->first();
        if($user){
            $token = rand(2,1000000000000000000); //generate random token
            try{
                $email = $user->email;
                // return response($email);
                DB::table('password_resets')->insert([
                    'email' => $email,
                    'token' => $token,
                ]);
                Mail::to($user)->queue(new ForgotPassMail($user->name, $token)); //email sending

                return response([
                    'message' => 'Reset Password Link Send to Your Register Email Address',
                    'token' => $token,
                ],200);

            }catch(Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ],400);
            }
            
            return;
        }else{
            return response()->json(["message" => "User Not Found"], 401);
        }
    }

    //reset password
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $password = bcrypt($request->password);
        $token = $request->token;
       
        $tokencheck = DB::table('password_resets')->where('token' , $token)->first();
        if(!$tokencheck ){
            return response([
                'message' => "Token Doesn't match"
            ],401);
        }

        $user = DB::table('password_resets')->where('token',$token)->first();
        DB::table('users')->where('email',$user->email)->update(['password'=>$password]);
        DB::table('password_resets')->where('email',$user->email)->delete();
        return response([
            'message' => "Password Successfully Update"
        ],200);
    }

    // fetach managers
    public function managers($org){
        $user = User::with('organization')->where('role_id','=',3)->where("organization_id","=",$org)->get();
        return response()->json($user);
    }

    public function workers($org){
        $user = User::with('organization')->where('role_id','=',4)->where("organization_id","=",$org)->get();
        return response()->json($user);
    }

    public function getUser($id){
        $user = User::findOrFail($id);
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
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $input = $request->all();
        if(DB::table('users')->where('email',$input['email'])->where('id','!=',$id)->exists()){
            return response()->json(['message' => 'This Email Already Exist for another user'], 400);
        }

        if(!DB::table('users')->where('id',$id)->exists()){
            return response()->json(['message' => "User id Doesn't Exits"], 400);
        }

        $user = DB::table('users')->where('id',$id)->update(['name'=>$request->name, 'email'=> $request->email]);
        return response()->json($user, 200);
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
