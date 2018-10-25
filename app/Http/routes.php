<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function(){
        if(!auth()->guard('web')->check()) return view('welcome');
        $user = auth()->guard('web')->user();
        return view('main', compact('user'));
    });

    Route::controller('login', 'Auth\AuthController');

    // aborts at __construct if !authenticated
    Route::group(['middlware'=>'throttle'], function(){
        Route::controller('twitch', 'TwitchController');
        Route::controller('facebook', 'FacebookController');
        Route::controller('twitter', 'TwitterController');
        Route::controller('youtube', 'YoutubeController');
        Route::controller('reddit', 'RedditController');
//        Route::controller('steam', 'SteamController');
    });

});