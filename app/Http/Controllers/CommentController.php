<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDO;

class CommentController extends Controller
{

    public function task_comments($task_id){
        $comments=Comment::with('user')->where('task_id' , '=', $task_id)->orderBy('created_at','DESC')->get();
        return $comments;
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
            'body' => 'required',
            'user_id' => 'required',
            'task_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $input = $request->all();
        Comment::create($input);
        return response()->json("Comment Created", 201);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment_id)
    {
        $comment=Comment::findOrFail($comment_id);
        $validator = Validator::make($request->all(), [
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $input = $request->all();
        $comment["body"]=$input["body"];
        $comment->save();
        $comment["updated_at"] = now();
        return response()->json($comment,200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        $comment=Comment::findOrFail($comment_id);
        $comment->delete();        
        return response()->json('Comment Deleted',200);
    }
}
