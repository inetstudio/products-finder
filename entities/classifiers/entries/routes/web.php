<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/products-finder/classifiers',
    ],
    function () {
        Route::any(
            'entries/data',
            'DataControllerContract@data'
        )->name('back.products-finder.classifiers.entries.data.index');

        Route::resource(
            'entries',
            'ResourceControllerContract',
            [
                'only' => [
                    'index',
                ],
                'as' => 'back.products-finder.classifiers',
            ]
        );
    }
);
