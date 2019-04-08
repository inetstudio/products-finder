<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/products-finder',
    ], function () {
        Route::any(
            'products/data',
            'DataControllerContract@data'
        )->name('back.products-finder.products.data.index');

        Route::post(
            'products/suggestions',
            'UtilityControllerContract@getSuggestions'
        )->name('back.products-finder.products.getSuggestions');

        Route::resource(
            'products', 'ResourceControllerContract', [
                'except' => [
                    'show',
                ],
                'as' => 'back.products-finder'
            ]
        );
    }
);
