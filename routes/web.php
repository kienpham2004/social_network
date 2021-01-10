<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function(){
    return view('welcome');
})->name('index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'locale'], function () {
    Route::get('/home/{lang}', 'SwitchLanguage@setLocale')->name('home.lang');
    Route::get('/profile', 'HomeController@profile')->name('home.profile');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile/your-profile', 'ProfileController@index')->name('profile.index');
    Route::post('/profile/post-status', 'ProfileController@postStatus')->name('profile.post_status');
    Route::patch('/profile/upload-avatar/{id}', 'ProfileController@uploadAvatar')->name('profile.upload_avatar');
    Route::get('/profile/{username}', 'TimeLineController@viewUser')->name('wall.your_friend');
    Route::post('/search', 'SearchController@search')->name('search');
    Route::post('/follow', 'FollowController@follow')->name('user.follow');
    Route::delete('/unfollow/{id}', 'FollowController@unfollow')->name('user.unfollow');
    Route::post('/home/comment/add', 'CommentController@comment')->name('comment.add');
    Route::patch('/comment/edit/{id}', 'CommentController@editComment')->name('comment.edit');
    Route::delete('/comment/delete/{id}', 'CommentController@deleteComment')->name('comment.delete');
    Route::post('/like/post', 'LikeController@like')->name('like');
    Route::delete('/unlike/post/{id}', 'LikeController@unlike')->name('unlike');
    Route::get('/show-post/{id}', 'ProfileController@showPost')->name('profile.show-post');
    Route::get('/back/{id}', 'ProfileController@back')->name('profile.back');
    Route::post('/home/load-post', 'HomeController@loadPost')->name('home.load_post');
    Route::post('/home/view-comment', 'HomeController@viewComment')->name('home.view_comment');
});
