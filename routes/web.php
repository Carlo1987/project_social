<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;    //  aggiunto per creare / accedere ai pdf  
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

  

//////////////   rotte generali   /////////////////////////


Route::middleware(['RefreshAuthSession'])->group(function(){        //   middleware che riaggiorna la sessione utente con cookie, valido per tutte le rotte



Route::middleware(['NoLogin'])->group(function(){
       Route::get('/',  function(){  return view('auth.login');  } )->name('home');
       Route::get('/login', function(){  return view('auth.login');  })->name('login.view');     
       Route::get('/register', function(){  return view('auth.register');  })->name('register');    
});


Route::post('/login', 'App\Http\Controllers\Auth\LoginCustomController@login')->name('login');     
Route::post('/register', 'App\Http\Controllers\Auth\RegisterCustomController@register')->name('register');     
Route::get('/home', function(){  return view('home');  })->name('welcome');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginCustomController@logout')->name('logout');


//////////////   rotte download lista utenti   /////////////////////////
Route::get('/download', function(){
       $users = User::all();
       $pdf = PDF::loadView('pdf.pdf',['users'=>$users]);    
       return $pdf->stream();
});


//////////////   rotte utenti   /////////////////////////

Route::resource('users', 'App\Http\Controllers\UserController');
Route::get('user/editDatos', 'App\Http\Controllers\UserController@editDatos')->name('editDatos');
Route::get('user/editPassword', 'App\Http\Controllers\UserController@editPassword')->name('editPassword');
Route::post('user/updatePassword', 'App\Http\Controllers\UserController@updatePassword')->name('updatePassword');
Route::get('user/avatar', 'App\Http\Controllers\UserController@avatar')->name('avatar');
Route::post('user/updateAvatar', 'App\Http\Controllers\UserController@updateAvatar')->name('updateAvatar');
Route::get('/user/getAvatar/{avatar?}', 'App\Http\Controllers\UserController@getAvatar')->name('getAvatar');
Route::get('user/theme', 'App\Http\Controllers\UserController@theme')->name('theme');
Route::post('user/changeTheme', 'App\Http\Controllers\UserController@change_theme')->name('change.theme');
Route::get('user/delete/{id}', 'App\Http\Controllers\UserController@delete')->name('user.delete');
Route::post('user/deleteAcount/{id}', 'App\Http\Controllers\UserController@deleteAcount')->name('deleteAcount');
Route::post('user/search','App\Http\Controllers\UserController@search')->name('user.search');
Route::get('user/chats', 'App\Http\Controllers\UserController@show_chats')->name('chats');

//////////////   rotte per verifica Acount e reset password  utente   /////////////////////////

Route::get('forgot-password','App\Http\Controllers\password\ResetPasswordController@show')->middleware('guest')->name('password.request');
Route::post('email-password','App\Http\Controllers\password\ResetPasswordController@email')->middleware('guest')->name('password.email');
Route::get('token/{token}','App\Http\Controllers\password\ResetPasswordController@reset')->middleware('guest')->name('password.reset');
Route::post('reset-password','App\Http\Controllers\password\ResetPasswordController@update')->middleware('guest')->name('password.update');   

//////////////   rotte immagini   /////////////////////////

Route::resource('images', 'App\Http\Controllers\ImageController');
Route::get('image/detail/{id}','App\Http\Controllers\ImageController@detail')->name('image.detail');
Route::get('image/delete/{id}','App\Http\Controllers\ImageController@delete');

//////////////   rotte video   /////////////////////////

Route::resource('videos', 'App\Http\Controllers\VideoController');
Route::get('video/detail/{id}','App\Http\Controllers\VideoController@detail')->name('video.detail');
Route::get('video/delete/{id}','App\Http\Controllers\VideoController@delete');

//////////////   rotte commenti   /////////////////////////

Route::resource('comments', 'App\Http\Controllers\CommentController');
Route::get('comment/delete/{id}', 'App\Http\Controllers\CommentController@delete')->name('comment.delete');

//////////////   rotte like   /////////////////////////

Route::get('like_image/{image_id}','App\Http\Controllers\LikeController@like_image');
Route::get('dislike_image/{image_id}','App\Http\Controllers\LikeController@dislike_image');
Route::get('like_video/{video_id}','App\Http\Controllers\LikeController@like_video');
Route::get('dislike_video/{video_id}','App\Http\Controllers\LikeController@dislike_video');

//////////////   rotte richieste di amicizia   /////////////////////////

Route::resource('friendships', 'App\Http\Controllers\FriendshipController');
Route::get('friendship/delete/{id}', 'App\Http\Controllers\FriendshipController@delete')->name('friendship.delete');


//////////////   rotte lista amicizie   /////////////////////////

Route::resource('friendlists', 'App\Http\Controllers\FriendlistController');
Route::get('friendlist/delete/{friendlist}', 'App\Http\Controllers\FriendlistController@delete')->name('friendlist.delete');


});
