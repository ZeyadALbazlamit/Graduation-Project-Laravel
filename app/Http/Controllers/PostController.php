<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\imgCollection;
use App\comment;
use App\Interests;
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
    public function show($post)
    {

        return response()->json(["post"=>Post::find($post),"image"=>Post::find($post)->img,"user"=>Post::find($post)->user  ]);
    }

    public function byCategory($post, Request $request)
    {
        if ($request->location=="كل المدن") {
            $posts=DB::select('select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id=? limit ?,?', [$post,($request->page-1)*$request->count,$request->count  ]);
        } else {
            $posts=DB::select('select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where location in (?) and  category_id=? limit ?,?', [$request->location,$post,($request->page-1)*$request->count,$request->count  ]);
        }

        $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts where category_id=:p)  ', ["p"=>$post,"userId"=>$request->user_id]);
        $int =new Interests();
        $int->category_id=$post;
        $int->user_id= $request->user_id;
        $int->save();
        return response()->json(['posts'=>$posts,"fav"=>$fav]);
    }

    public function search(Request $request)
    {/*
        $int=DB::select('select id   from categories');

        for ($x = 1; $x < count($int); $x++) {

            $int[$x]= DB::select('select category_id, count(categories.id) count from categories  join interests where interests.category_id=categories.id   and    categories.id=? GROUP BY category_id',[$int[$x]->id]);



        }

        return response()->json( $int);
*/

        //select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where category_id !=13 //all
        //select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  Sub_Category_name=   "ستيرو - مسجلات - راديو"
        switch ($request->type) {

                case "product":$res= searchByProduct($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
                case "service":$res =searchByService($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
                case "search":$res =search($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
                case "text":$res =searchByText($request->user_id, $request->page, $request->count, $request->text, $request->order_by, $request->location);break;

    }
        return response()->json($res);
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

 function searchByProduct($userId, $page, $count, $order, $loc)
 {
     $page --;/*
     if ($loc=="كل المدن") {
         $posts= DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id !=13 order by ? limit ?,? ", [$order,$page * $count ,$count]);
     } else {
         $posts= DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location in (? ) and  category_id !=13 order by ? limit ?,? ", [$loc,$order,$page * $count ,$count]);
     }*/
     $posts= DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id !=13  and location ".$loc. "  order by ". $order. " limit ?,? ", [$page * $count ,$count]);

     $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts where category_id !=13)', ["userId"=>$userId]);
     $count=DB::select("select count(*) count from posts where category_id !=13");
     return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
 }

 function searchByService($userId, $page, $count, $order, $loc)
 {
     $page --;
     $posts= DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id=13  and location ".$loc. "  order by ". $order. " limit ?,? ", [$page * $count ,$count]);

     /*
     if ($loc=="كل المدن") {
         $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where    category_id =13 order by ? limit ?,? ", [$order,$page * $count ,$count]);
     } else {
         $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location in (? ) and  category_id =13 order by ? limit ?,? ", [$loc,$order,$page * $count ,$count]);
     }*/
     $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts where category_id=13)', ["userId"=>$userId]);
     $count=DB::select("select count(*) count from posts where category_id =13");
     return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
 }
function search($userId, $page, $count, $order, $loc)
{

    $page --;

    $posts= DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location  ".$loc. "  order by ".$order ." limit ?,? ", [$page * $count ,$count]);
/*
    if ($loc=="كل المدن") {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  order by ?  limit ?,? ", [$order,$page * $count ,$count]);
    } else {

        //$posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location  in (? ) order by ?  limit ?,? ", [$loc,$order,$page * $count ,$count]);
    }*/
    $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts )', ["userId"=>$userId]);
    $count=DB::select("select count(*) count from posts");
    return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
}
function searchByText($userId, $page, $count, $text, $order, $loc)
{
    $page --;
    if(ord($text)>57)
{

$posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where   location  ".$loc. "  and  title=?  order by ".$order. " limit ?,? ", [ $text,$page * $count ,$count]);

/*
    if ($loc=="كل المدن") {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where    title=?  order by ? limit ?,? ", [ $text,$order,$page * $count ,$count]);
    } else {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where  location in (? ) and  title=?  order by ? limit ?,? ", [ $loc,$text,$order,$page * $count ,$count]);
    }

    */


    $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts )', ["userId"=>$userId]);
    $count=DB::select("select count(*) count from posts");


$cat=DB::select(' select id from posts where title =? ',[$text]);
if (count($cat)>0) {
    $int =new Interests();
    $int->category_id=$cat[0]->id;
    $int->user_id=$userId;
    $int->save();
}


}
else{
/*
    if ($loc=="كل المدن") {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where    id=?  order by ? limit ?,? ", [ $text,$order,$page * $count ,$count]);
    } else {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where  location in (? ) and  id=?  order by ? limit ?,? ", [ $loc,$text,$order,$page * $count ,$count]);
    }

    */
    $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where  location ".$loc." and  id=? order by ".$order." limit ?,? ", [ $text,$page * $count ,$count]);
    $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts )', ["userId"=>$userId]);
    $count=DB::select("select count(*) count from posts");

    $int =new Interests();
    $int->category_id=Post::find($text)->category_id;
    $int->user_id=$userId;
    $int->save();
}
    return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
}
