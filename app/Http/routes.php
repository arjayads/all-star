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
Route::get('/profile', 'MembersController@myProfile');

Route::get('videos', 'VideosController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'videos'], function () {
        Route::post('update/{id}', 'AdminController@update');
        Route::post('delete/{id}', 'AdminController@destroy');
    });
});

Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'find'], function () {
        Route::get('members', 'MembersController@find');
    });
});

Route::group(['prefix' => 'member', 'middleware' => 'auth'], function () {
        Route::get('profile', 'MembersController@profile');
        Route::post('requestAdd', 'MembersController@requestAdd');
        Route::post('requestCancel', 'MembersController@requestCancel');
        Route::post('requestProcess', 'MembersController@requestProcess');

        Route::get('addToTeam', 'MembersController@addToTeamView');
        Route::post('addToTeam', 'MembersController@addToTeam');
});

Route::resource('admin/videos', 'AdminController');

