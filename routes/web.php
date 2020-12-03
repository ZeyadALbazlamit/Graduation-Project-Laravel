<?php

use Illuminate\Support\Facades\Route;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
////login by face
Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

//////////////
Route::Resource('/Post', 'postController');
Route::Resource('/Category', 'categoryController');
Route::Resource('/User', 'UserController');
Route::Resource('/Comment', 'CommentController');


////////////
Route::get('/Message', function ( ) {
   event(new  App\Events\puplicMessage("Hello baby"));
    return '$success';
});
Route::get('/Message/{id}',function (){
  event(new App\Events\privateMessage('hi',7));
   return 'success';
});

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

