<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/products-finder',
    ],
    function () {
        Route::any(
            'products/datatables/{service}/data',
            'DataControllerContract@getData'
        )->name('back.products-finder.products.datatables.data');

        Route::any(
            'products/datatables/{service}/html',
            'DataControllerContract@getHtml'
        )->name('back.products-finder.products.datatables.html');

        Route::any(
            'products/datatables/{service}/options',
            'DataControllerContract@getOptions'
        )->name('back.products-finder.products.datatables.options');

        Route::post(
            'products/suggestions',
            'UtilityControllerContract@getSuggestions'
        )->name('back.products-finder.products.getSuggestions');

        Route::resource(
            'products', 'ResourceControllerContract', [
                'except' => [
                    'show',
                ],
                'as' => 'back.products-finder',
            ]
        );
    }
);
