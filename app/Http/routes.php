<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login/{provider}', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/', 'VideosController@index');
Route::get('videos', 'VideosController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'videos'], function () {
        Route::post('update/{id}', 'AdminController@update');
        Route::post('delete/{id}', 'AdminController@destroy');
    });
});

Route::resource('admin/videos', 'AdminController');

