<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
   public function register(Request $request)
   {

    $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required',
            'password'=>'required|confirmed'
        ]);

    $validatedData['password'] = bcrypt($request->password);

    $user = User::create($validatedData);

    $accessToken = $user->createToken('authToken')->accessToken;

    return response(['user'=> $user, 'access_token'=> $accessToken]);

   }


   public function login(Request $request)
   {

    if ($request->has('provider')) {
       $user= User::where('email',$request->email)->where('provider',$request->provider )->first();
       if($user)
          return response(['user' => $user]);
          else
       {
        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required',

        ]);
      $user = User::create($validatedData);
            if(  $request->provider=="facebook"){
             $user->img=$request->img["data"]['url'];
}
        else
                $user->img=$request->img;
                $user->provider=$request->provider;

                $user->save();
      return response(['user'=> $user]);

       }


    }
else{
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            //    return response(['message'=>'Invalid credentials']);
        }

       // $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user()]);
    }
   }
}
User::where('email',"zeyadalbazlamit@gmyail.com")->first();
