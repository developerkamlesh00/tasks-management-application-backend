<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ProjectCreated;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'title' => 'required',
            'description' => 'required',
            'assigned_at' => 'required',
            'estimated_deadline' => 'required',
            'organization_id' => 'required',
            'manager_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        //uncomment when project is completed
        // $user = User::findOrFail($input['manager_id']);
        // Mail::to($user)->queue(new ProjectCreated($input, $user)); //for email sending


        Project::create($input);
        return response()->json("Project Created", 200);
    }


    //get all projects related to organization
    public function getProjects($org){
        return Project::with('user')->where("organization_id","=",$org)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project)
    {
        $project = Project::findOrFail($project);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'assigned_at' => 'required',
            'estimated_deadline' => 'required',
            'organization_id' => 'required',
            'manager_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        $project["title"] = $input["title"];
        $project["description"] = $input["description"];
        $project["assigned_at"] = $input["assigned_at"];
        $project["estimated_deadline"] = $input["estimated_deadline"];
        $project["organization_id"] = $input["organization_id"];
        $project["manager_id"] = $input["manager_id"];
        $project["updated_at"] = now();
        
        $project->save();
        return response()->json($project,200);
        
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project){
            $project->delete();
            return response()->json(['message' => 'Successfully Deleted'], 200);
        }else{
            return response()->json(['message' => 'Project Not Found.'], 404);
        }
    }
}
