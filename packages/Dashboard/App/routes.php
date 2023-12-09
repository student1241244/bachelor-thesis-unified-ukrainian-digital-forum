<?php

/**
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(
    [
        'prefix'     => class_exists('\Packages\Dashboard\App\Services\Route\RouteService')
            ? \Packages\Dashboard\App\Services\Route\RouteService::getPrefix()
            : \Packages\Dashboard\App\Services\Route\BaseRouteService::getPrefix(),
        'middleware' => ['web', 'userActive', 'permission'],
        'namespace'  => 'Packages\Dashboard\App\Controllers',
        'as'         => 'dashboard.'
    ],
    function () {

        /**
         * Authentication
         */

        Route::get('login', 'AuthController@showLoginForm')->name('login');
        Route::post('login', 'AuthController@login')->name('login.submit');
        Route::any('logout', 'AuthController@logout')->name('logout');

        Route::group(
            [
                'as' => 'password.',
            ],
            function () {
                Route::get('reset-password', 'ResetPasswordController@index')->name('reset.index');
                Route::post('reset-password', 'ResetPasswordController@send')->name('reset.send');
                Route::get('set-password/{token}', 'SetPasswordController@index')->name('set.index');
                Route::post('set-password/{token}', 'SetPasswordController@send')->name('set.send');
            }
        );

        /**
         * Media.
         */
        Route::group(
            [
                'as'        => 'media.',
            ], function () {
            Route::post('redactorjs-upload', ['as' => 'redactorjs', 'uses' => 'MediaController@redactorJsUpload']);
            Route::get('delete-media/{media}', ['as' => 'delete', 'uses' => 'MediaController@destroy']);
            Route::get('/{media}/download', ['as' => 'download', 'uses' => 'MediaController@download']);
        });

        /**
         * Dashboard Index
         */
        Route::get('', 'DashboardController@index')->name('dashboard.index');
        Route::get('counters', 'DashboardController@counters')->name('counters');
        Route::get('config', 'AccountController@edit')->name('account.edit');
        Route::post('config', 'AccountController@update')->name('account.update');
        Route::post('config/password', 'AccountController@password')->name('account.password');
        Route::get('users/{user}/view-log', 'UserController@viewLog')->name('users.view_log');
        Route::get('users/{user}/clear-log', 'UserController@clearLog')->name('users.clear_log');
        Route::resource('users', 'UserController', ['except' => ['show']]);
        Route::resource('roles', 'RoleController', ['except' => ['show']]);
        Route::resource('languages', 'LanguageController', ['except' => ['show']]);

        Route::group(
            [
                'prefix' => 'translations',
                'as' => 'translations.',
            ], function () {
            Route::get('', ['as' => 'index', 'uses' => 'TranslationController@index']);
            Route::get('{translation}/edit', ['as' => 'edit', 'uses' => 'TranslationController@edit']);
            Route::put('{translation}', ['as' => 'update', 'uses' => 'TranslationController@update']);
            Route::get('/export', ['as' => 'export', 'uses' => 'TranslationController@export']);
            Route::post('/import', ['as' => 'import', 'uses' => 'TranslationController@import']);
            Route::put('/{translation}', ['as' => 'update', 'uses' => 'TranslationController@update']);
        });

});
