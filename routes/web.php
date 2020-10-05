<?php

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

//ルーティング
// MicropostsController の index アクションが呼ばれるようになっている。
Route::get('/', 'MicropostsController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');




//ユーザー機能
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    //お気に入り登録機能の追記
        Route::post('star', 'UserStarController@store')->name('user.star');
        Route::delete('unstar', 'UserStarController@destroy')->name('user.unstar');
        Route::get('starings', 'UsersController@starings')->name('users.starings');
        //Route::get('starers', 'micropostsController@starers')->name('users.starers'); いらない

    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});


