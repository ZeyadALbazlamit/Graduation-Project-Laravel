<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all()->get());
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
        //
    }


    public function showStore(Request $request)
    {

$com=DB::select('select * from users where type="company"  and  name '.$request->name.'  and location '.$request->location.'     ',[]);
    return response()->json($com);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user=User::find($user_id);
        if ($user) {
           $post=User::find($user_id)->post;

           $favorite=DB::select("select * from posts join favorites where  favorites.post_id=posts.id and  favorites.user_id=? ",[$user_id]);

        } else {
            $post=[];
            $favorite=[];
        }

        return response()->json(["user"=>$user,'post'=>$post,"favorite"=>$favorite ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return reponse()->json(User::find($id));
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
        $user=User::find($id);

         if( $request->has('name')) $user->name=$request->name;
         // no break
         if( $request->has('email')) $user->email=$request->email;
         // no break
         if( $request->has('img')) $user->img=$request->img;
         // no break
         if( $request->has('phone_number')) $user->phone_number=$request->phone_number;
         // no break
         if( $request->has('location')) $user->location=$request->location;
         // no break
         if( $request->has('type')) $user->type=$request->type;
         // no break

        $user->save();
        return response()->json($user);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id)->first();
        if($user){

           $user->delete();

           DB::delete('delete from posts where user_id =?'.[$id]);
           DB::delete('delete from comments where user_id =?'.[$id]);
           DB::delete('delete from reports where user_id =?'.[$id]);
           DB::delete('delete from favorites where user_id =?'.[$id]);
           DB::delete('delete from carts where user_id =?'.[$id]);

        }
    }
}
