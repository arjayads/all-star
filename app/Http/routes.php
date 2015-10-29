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
Route::get('auth/login', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/', 'StaticPageController@index');
Route::get('/profile', 'MembersController@myProfile');

Route::group(['prefix' => 'videos', 'middleware' => 'auth'], function () {
    Route::get('/', 'VideosController@index');
    Route::get('/cat/{id}', 'VideosController@byCategory');
    Route::get('/prev/{id}', 'VideosController@preview');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'Admin\HomeController@index');
    Route::group(['prefix' => 'videos'], function () {
        Route::get('/{id}/edit', 'Admin\VideosController@edit');
        Route::get('/upload', 'Admin\VideosController@create');
        Route::get('/{id}', 'Admin\VideosController@show');
        Route::get('/', 'Admin\VideosController@index');
        Route::post('store', 'Admin\VideosController@store');
        Route::post('update/{id}', 'Admin\VideosController@update');
        Route::post('delete/{id}', 'Admin\VideosController@destroy');
    });
});

Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'find'], function () {
        Route::get('members', 'MembersController@find');
        Route::get('downlines', 'MembersController@downlines');
    });
});

Route::group(['prefix' => 'member', 'middleware' => 'auth'], function () {
        Route::get('profile', 'MembersController@profile');
        Route::post('requestAdd', 'MembersController@requestAdd');
        Route::post('requestCancel', 'MembersController@requestCancel');
        Route::post('requestProcess', 'MembersController@requestProcess');

        Route::get('addToTeam', 'MembersController@addToTeamView');
        Route::post('addToTeam', 'MembersController@addToTeam');
        Route::post('removeTeamMember', 'MembersController@removeTeamMember');
});


//Route::resource('admin/videos', 'AdminController');

