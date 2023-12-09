<?php
/*
|--------------------------------------------------------------------------
| Questions Routes
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
        'namespace'  => 'Packages\Questions\App\Controllers',
        'as'         => 'questions.'
    ],
    function () {
		Route::resource('questions', 'QuestionController', ['except' => ['show']]);

		Route::resource('questions/comments', 'CommentController', ['except' => ['show']]);


    });
