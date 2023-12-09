<?php

use Packages\Dashboard\App\Controllers\Api\MediaController;

Route::group([
    'prefix'     => 'media',
    'as'         => 'api.media.'
],
    function () {
        Route::post('', [MediaController::class, 'upload'])->name('upload');
    });
