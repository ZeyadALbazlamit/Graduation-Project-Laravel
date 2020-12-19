<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
//////////////
Route::Resource('/Post', 'postController');
Route::Resource('/Category', 'categoryController');
Route::Resource('/User', 'UserController');
Route::Resource('/Comment', 'CommentController');
Route::Resource('/img', 'imgCollectionController');


////////////
Route::get('/Message', function ( ) {
   event(new  App\Events\puplicMessage("Hello baby"));
    return '$success';
});
Route::get('/Message/{id}',function (){
  event(new App\Events\privateMessage('hi',7));
   return 'success';
});

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
Route::post('/Message',function (Request $request){
if ($request->data) {
    event(new App\Events\puplicMessage($request->data, 7));
    return $request->data;
}
return '00000';
  });


Route::middleware('auth')-> get('/recipient', function ( ) {
return view('recipient');
});
Route::get('/sender', 'CommentController@index');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/react-Message', function () {
return view('comment');
});
Route::get('/DashBoard', function () {
    $counts=['User'=>App\User::count(),'Post'=>App\Post::count(),'Comment'=>App\comment::count(),'Category'=>App\category::count()];

    return view('DashBoard',["counts"=>$counts]);
});

///////////////\

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/verified-only', function(Request $request){

    dd('your are verified', $request->user()->name);
})->middleware('auth:api','verified');


Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@reset');


Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');

Route::apiResource('tasks','Api\TasksController')->middleware('auth:api');
