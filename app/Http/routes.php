<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('logout', function () {
    Auth::logout();

    return redirect('/');
});

// As an example.
Route::get('dashboard', function () {
    return 'You are authorized to see this page!!';
})->middleware('auth');





