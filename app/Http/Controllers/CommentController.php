<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\comment;
use App\User;
use App\Post;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json(comment::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return view("");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $comment=new comment;
     $comment->post_id=$request->post_id;
     $comment->body=$request->body;
     $comment->user_id=$request->user_id;
     $comment->save();
     $comment->UserName=  User::find($request->user_id)->name; // App\Comment::find($comment->user_id) ;
      return response()->json($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show( $Post)
    {
        return  response()->json( DB::select('select user_id,post_id, body,name,img, comments.created_at ,comments.id id from users
             join comments  where users.id=comments.user_id  and post_id=:postid',['postid'=>$Post]) );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        //
    }
}
