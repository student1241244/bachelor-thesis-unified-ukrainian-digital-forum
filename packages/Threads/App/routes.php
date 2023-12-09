<?php
/*
|--------------------------------------------------------------------------
| Threads Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(
    [
        'prefix'     => \Packages\Dashboard\App\Services\Route\RouteService::getPrefix(),
        'middleware' => ['web', 'userActive', 'permission'],
        'namespace'  => 'Packages\Threads\App\Controllers',
        'as'         => 'threads.'
    ],
    function () {
		Route::resource('threads/categories', 'CategoryController', ['except' => ['show']]);

		Route::resource('threads', 'ThreadController', ['except' => ['show']]);

		Route::resource('threads/comments', 'CommentController', ['except' => ['show']]);


    });
