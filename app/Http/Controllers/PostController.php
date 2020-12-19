<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use App\imgCollection;
use App\comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select('select id,Sub_Category_name,price,rate,created_at ,main_img from posts');
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
      $post=new post;
      $post->title=$request[1]['title'];
      $post->user_id=$request[3];
      $post->category_id=$request[1]['category_id'];
      $post->Sub_Category_name=$request[1]['Sub_Category_name'];
      $post->Description=$request[1]['Description'];
      $post->price=$request[1]['price'];
      $post->location=$request[1]['location'];
     // $post->rate=$request[1]['rate'];
      $post->pro=$request[0];//json
      $post->main_img=$request[2][0];
     $post->save();
     ////////////
       $arr=[];
        for ($i=0;$i<count($request[2]);$i++) {
            $img=new imgCollection();
            $img->post_id= $post->id;
            $img->img=$request[2][$i];
            $img->save();
            $arr[$i]= $img->img;
        }
        return response()->json(["post" =>$post,"image"=>$arr]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show( $post)
    {
        return response()->json(["post"=>Post::find($post),"image"=>Post::find($post)->img,'comments'=> DB::select('select id,Sub_Category_name,price,rate,created_at ,main_img from posts')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
