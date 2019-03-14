<?php

Route::group([
    'namespace' => 'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back/products-finder',
], function () {
    Route::any('products/data', 'ProductsDataControllerContract@data')->name('back.products-finder.products.data.index');
    Route::post('products/suggestions', 'ProductsUtilityControllerContract@getSuggestions')->name('back.products-finder.products.getSuggestions');

    Route::resource('products', 'ProductsControllerContract', ['except' => [
        'show',
    ], 'as' => 'back.products-finder']);
});
