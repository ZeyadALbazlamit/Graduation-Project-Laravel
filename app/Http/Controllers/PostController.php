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
        return DB::select('select id,title,Sub_Category_name,price,rate,created_at ,main_img from posts');
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
    $posts=DB::select('select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where location '.$request->location.' and  category_id=? order by '.$request->order_by.' limit ?,?', [$post,($request->page-1)*$request->count,$request->count  ]);


        $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts where category_id=:p)  ', ["p"=>$post,"userId"=>$request->user_id]);
        $count=DB::select("select count(*) count from posts    where  category_id=?  and location  ".$request->location. " GROUP BY id  order by ".$request->order_by ."  ",[$post]);

        $in=DB::select("select id from interests where user_id=? and category_id=? ", [$request->user_id,$post]);
        if (count($in)>0) {
            $int=interests::find($in[0]->id);
            $int->count=$int->count+1;
            $int->save();
        }
     else {
        $int =new Interests();
        $int->category_id=$post;
        $int->user_id=$request->user_id;
        $int->count=1;
        $int->save();
    }



        return response()->json(['posts'=>$posts,"fav"=>$fav,"count"=>count($count)]);
    }

    public function search(Request $request)
    {/*
        $int=DB::select('select id   from categories');

        for ($x = 1; $x < count($int); $x++) {

            $int[$x]= DB::select('select category_id, count(categories.id) count from categories  join interests where interests.category_id=categories.id   and    categories.id=? GROUP BY category_id',[$int[$x]->id]);



        }

        return response()->json( $int);
*/

if($request->order_by=="Recommended"){


}
    //select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where category_id !=13 //all
    //select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  Sub_Category_name=   "ستيرو - مسجلات - راديو"
    switch ($request->type) {
           // select  posts.id ,posts.price,posts.location,interests.category_id,count from posts join interests where posts.category_id=interests.category_id and interests.user_id=2 order by  count desc
           case "product":$res= searchByProduct($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
                case "service":$res =searchByService($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
              //  case "search":$res =search($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
                case "text":$res =searchByText($request->user_id, $request->page, $request->count, $request->text, $request->order_by, $request->location);break;
               case 'Recommended': $res= searchByRecommended($request->user_id, $request->page, $request->count, $request->order_by, $request->location);break;
               case "company":$res=searchByCompany( $request->com_id,$request->user_id );  break;
               case "user":$res=searchByUser($request->name);  break;
               case "posts":$res=searchByPosts($request->title);  break;
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
    public function destroy($id)
    {
       DB::delete('delete from posts where id=?',[$id]);
       return response()->json(['messge'=>'was  deleted']);
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
     $posts= DB::select("select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id !=13  and location ".$loc. "  order by ". $order. " limit ?,? ", [$page * $count ,$count]);

     $fav=DB::select('select post_id from favorites  where favorites.user_id=? and post_id in(select id from posts where category_id !=13   and location '.$loc. "  order by ". $order. "  )", [$userId]);
     $count=DB::select("select count(*) count from posts     where category_id !=13");
     return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
 }

 function searchByService($userId, $page, $count, $order, $loc)
 {
     $page --;
     $posts= DB::select("select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts  where  category_id=13  and location ".$loc. "  order by ". $order. " limit ?,? ", [$page * $count ,$count]);

     $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts where category_id=13)', ["userId"=>$userId]);
     $count=DB::select("select count(*) count from posts where category_id =13");
     return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
 }
function search($userId, $page, $count, $order, $loc)
{

    $page --;

    $posts= DB::select("select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location  ".$loc. "  order by ".$order ." limit ?,? ", [$page * $count ,$count]);

    $fav=DB::select('select post_id from favorites  where favorites.user_id=؟ and post_id in(select id from posts    where location  '.$loc. "  order by ".$order .")", [$userId]);
    $count=DB::select("select count(*) count from posts    where   location  ".$loc. "  order by ".$order ."  ");
    return ['posts'=>$posts,"fav"=>$fav ,"count"=>$count[0]->count];
}
function searchByText($userId, $page, $count, $text, $order, $loc)
{
    $page --;
    if(ord($text[1])>57)
{

$posts=DB::select("select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where   location  ".$loc. "  and  title like ?  order by ".$order. " limit ?,? ", [ $text,$page * $count ,$count]);
$fav=DB::select('select post_id from favorites  where favorites.user_id=? and post_id in(select id from posts where   location  '.$loc. "  and  title like ?  order by ".$order. '  )', [$userId,$text]);
$count=DB::select("select id  from posts where   location  ".$loc. "  and  title like ?  order by ".$order, [ $text]);

}
else{
    /*
        if ($loc=="كل المدن") {
            $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where    id=?  order by ? limit ?,? ", [ $text,$order,$page * $count ,$count]);
        } else {
            $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where  location in (? ) and  id=?  order by ? limit ?,? ", [ $loc,$text,$order,$page * $count ,$count]);
        }

        */
    $posts=DB::select("select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where  location ".$loc." and  id like ? order by ".$order." limit ?,? ", [ $text,$page * $count ,$count]);
    $fav=DB::select('select post_id from favorites  where favorites.user_id=:userId and post_id in(select id from posts )', ["userId"=>$userId]);
    $count=DB::select("select id from posts where  location ".$loc." and  id like ? order by ".$order, [ $text,$page * $count ,$count]);
   /* $cat=[];
    $cat=DB::select(' select category_id from posts where id =? ', [$text]);
    if (property_exists($cat[0], 'id')) {
        $in=DB::select("select id from interests where user_id=? and category_id=? ", [$userId,$cat[0]->id]);
        if (count($in)>0) {
            $int=interests::find($in[0]->id);
            $int->count=$int->count+1;
            $int->save();
        } else {
            $int =new Interests();
            $int->category_id=$cat[0]->id;
            $int->user_id=$userId;
            $int->count=1;
            $int->save();
        }
    }*/
}

    return ['posts'=>$posts,"fav"=>$fav ,"count"=>count($count)];
}

function searchByRecommended($userId, $page, $count, $order, $loc)
{
    $page --;
    $posts =DB::select('select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts join interests where posts.category_id=interests.category_id and interests.user_id=? and location '.$loc.'  order by  count desc, '.$order.' limit ?,?',[$userId,$page * $count ,$count]);
    /*
    if ($loc=="كل المدن") {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where    category_id =13 order by ? limit ?,? ", [$order,$page * $count ,$count]);
    } else {
        $posts=DB::select("select posts.id id,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where location in (? ) and  category_id =13 order by ? limit ?,? ", [$loc,$order,$page * $count ,$count]);
    }*/
    $fav=DB::select('select post_id from favorites  where favorites.user_id=? and post_id in( select posts.id  from posts join interests where posts.category_id=interests.category_id and interests.user_id=? and location '.$loc.'  order by  count desc, '.$order .')', [$userId,$userId]);
    $count=DB::select('select posts.id id from  posts join interests where posts.category_id=interests.category_id and interests.user_id=? and location '.$loc.'  order by  count desc, '.$order,[$userId]);
    return ['posts'=>$posts,"fav"=>$fav ,"count"=>count($count)];
}
 function searchByCompany($id,$userId)
{
    $posts =DB::select('select posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts where user_id =? ',[$id]);
    $fav=DB::select('select post_id from favorites  where favorites.user_id=? and post_id in (select posts.id from posts where user_id =?) ',[$userId,$id]);
    return ['posts'=>$posts,"fav"=>$fav];

}

function searchByUser($name)
{
    $users =DB::select('select id ,img , name ,location ,phone_number from users where name like ?',[$name]);
    return ["users"=>$users];

}
function searchByPosts($title)
{
    $posts =DB::select('select * from posts where title like ?',[$title]);
    return ["posts"=>$posts];

}
