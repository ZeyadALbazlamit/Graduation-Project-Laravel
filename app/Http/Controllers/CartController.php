<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CartController extends Controller
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
        $q=Cart::where('post_id', $request->post_id)->where('user_id', $request->user_id)->where('submit', false)->first();
        if ($q) {
            $q->count =$q->count+1;
            $q->save();
            return response()->json(["message"=>"count ++"]);
        }
        $car=new Cart();
        $car->user_id=$request->user_id;
        $car->post_id=$request->post_id;
        $car->count=1;
        // $car->color=$request->color;
        $car->submit=false;
        $car->save();
        return response()->json(["message"=>"crateed "]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
       //userCart
             $cart=DB::select("select  carts.deleted_at, carts.id cartId,submit ,count,posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts join carts where carts.post_id=posts.id and carts.user_id=? and carts.submit=false    ", [$userId]);
             $history=DB::select("select  carts.deleted_at,carts.id cartId,submit ,count,posts.id id,title,Sub_Category_name,price,rate,posts.created_at created_at ,main_img from posts join carts where carts.post_id=posts.id and carts.user_id=? and carts.submit=true  order by carts.id desc  ", [$userId]);
             return response()->json(['cart'=>$cart,'history'=>$history ]);



    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function showOrder(Request $request, $userId)
    {
        $order=DB::select("select  carts.deleted_at , users.id userId, users.img userImg ,users.name  userName,carts.id cartId  ,submit, count, posts.id id,title,Sub_Category_name,price,posts.created_at created_at ,main_img from posts join carts  join users  where  users.id=carts.user_id and  carts.post_id=posts.id  and carts.submit=true   and  carts.deleted_at is  null  and posts.id in (select id from posts where user_id=?) ", [$userId]);
        $history=DB::select("select  carts.deleted_at, users.id userId, users.img userImg ,users.name  userName,carts.id cartId  ,submit, count, posts.id id,title,Sub_Category_name,price,posts.created_at created_at ,main_img from posts join carts  join users  where  users.id=carts.user_id and  carts.post_id=posts.id  and carts.submit=true and  carts.deleted_at  is not null  and posts.id in (select id from posts where user_id=?) ", [$userId]);
        return response()->json(['order'=>$order,'history'=>$history ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cart)
    {
        if ($request->has("type")) {
            if ($request->type=="submitAll") {
                $update=DB::update(' update carts set submit=true where carts.user_id=?', [$cart]);
                return "submit all post from user ";
            } else {
                if ($request->type=="deleteAll") {
                    $delete=DB::delete('delete from carts where carts.user_id=? and submit=false ', [$cart]);
                    return "delete all non submit order  from user  for ever ";
                } else {
                    if ($request->type=="trashedSingleDelete" || $request->type=="forceSingleDelete") {
                        $car= Cart::withTrashed()->where('id', $cart)->first();
                        if ($request->type=="trashedSingleDelete"){
                             $car->delete();
                             return response()->json(["message"=>'Temporary deletion ']);
                            }
                        else
                        if ($request->type=="forceSingleDelete") {
                            $car->forceDelete();
                            return response()->json(["message"=>'Delete forever']);
                        }
                    }

                }
            }
        }
        else
         {
            $car=DB::update("update carts set submit=true where id=?", [$cart]);
            // $car= Cart::find($cart)->first();
            // $car->submit=true;
            // $car->save();
            return response()->json(["message update->"=>  $car]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $cart)
    {
        $car= Cart::withTrashed()->where('id', $cart)->first();
        if ($car) {
            if ($car->trashed()) {
                $car->forceDelete();
                return response()->json(["message"=>"FORCE dELETE after --"]);
            }
            else {
                if ($car->count ==1) {
                    $car->forceDelete();
                    return response()->json(["message"=>"deleted when count  <1 "]);
                } else {
                    $car->count=$car->count -1;
                    $car->save();
                    return response()->json(["message"=>"count --"]);
                }
            }
        }
    }
}
