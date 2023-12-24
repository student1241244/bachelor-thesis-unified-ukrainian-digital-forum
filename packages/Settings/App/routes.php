<?php
/*
|--------------------------------------------------------------------------
| Settings Routes
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
        'namespace'  => 'Packages\Settings\App\Controllers',
        'as'         => 'settings.'
    ],
    function () {
		Route::get('settings/custom', 'SettingsController@custom')->name('settings.custom');
		Route::resource('settings', 'SettingsController', ['except' => ['show']]);
    
    });
