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

// social login
Route::get('auth/login', 'StaticPageController@login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/login/{provider}', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/', 'StaticPageController@index');
Route::get('/profile', 'MembersController@myProfile');

Route::group(['prefix' => 'videos', 'middleware' => 'auth'], function () {
    Route::get('/', 'VideosController@index');
    Route::get('/{id}', 'VideosController@show');
    Route::get('/cat/{id}', 'VideosController@byCategory');
    Route::get('/prev/{id}', 'VideosController@preview');
});

Route::group(['prefix' => 'events', 'middleware' => 'auth'], function () {
    Route::get('/', 'EventsController@index');
    Route::get('/{id}/images', 'EventsController@images');
    Route::get('/image/{eventId}/{imageId}', 'EventsController@image');
    Route::get('/image/{eventId}/{imageId}/thumb', 'EventsController@imageThumb');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth2:Admin']], function () {
    Route::get('/', 'Admin\HomeController@index');
    Route::get('/changePassword', 'Admin\HomeController@changePasswordPage');
    Route::post('/changePassword', 'Admin\HomeController@changePassword');
    Route::group(['prefix' => 'videos'], function () {
        Route::get('/{id}/edit', 'Admin\VideosController@edit');
        Route::get('/upload', 'Admin\VideosController@create');
        Route::get('/{id}', 'Admin\VideosController@show');
        Route::get('/', 'Admin\VideosController@index');
        Route::post('store', 'Admin\VideosController@store');
        Route::post('update/{id}', 'Admin\VideosController@update');
        Route::post('delete/{id}', 'Admin\VideosController@destroy');
    });

    Route::group(['prefix' => 'events'], function () {
        Route::get('/', 'Admin\EventsController@index');
        Route::get('/add', 'Admin\EventsController@add');
        Route::get('/{id}/edit', 'Admin\EventsController@edit');
        Route::get('/{id}', 'Admin\EventsController@show');
        Route::get('/image/{eventId}/{imageId}/thumb', 'Admin\EventsController@imageThumb');
        Route::get('/image/{eventId}/{imageId}', 'Admin\EventsController@image');
        Route::post('store', 'Admin\EventsController@store');
        Route::post('update/{id}', 'Admin\EventsController@update');
        Route::post('delete/{id}', 'Admin\EventsController@destroy');
    });

    Route::group(['prefix' => 'calendar'], function () {
        Route::get('/', 'Admin\CalendarController@index');
        Route::post('store', 'Admin\CalendarController@store');
        Route::post('update/{id}', 'Admin\CalendarController@update');
        Route::post('delete/{id}', 'Admin\CalendarController@destroy');
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

