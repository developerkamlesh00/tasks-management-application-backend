<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function getOrganization($org){
        $org = Organization::where('id',$org)->first();
        return response()->json($org);
    }
    //update organization Details
    public function updateOrganization(Request $request){
        $validate = Validator::make($request->all(),[
            'id' => 'required',
            'org_name' => 'required',
            'org_email' => 'required|email',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $input = $request->all();
        if(DB::table('organizations')->where('id','!=',$input['id'])->where('org_email',$input['org_email'])->exists()){
            return response()->json(['message' => 'This Email Alredy Exist for another Organization'], 400);
        }

        if(!DB::table('organizations')->where('id',$input['id'])->exists()){
            return response()->json(['message' => "Organization id Doesn't Exits"], 400);
        }
        DB::table('organizations')->where('id',$input['id'])->update(['org_name'=>$input['org_name'],'org_email'=>$input['org_email']]);

        return response()->json('Successfull', 200);
    }
}
