<?php

Route::group([
    'namespace' => 'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back/products-finder/reviews',
], function () {
    Route::any('messages/data',
        'MessagesDataControllerContract@data')->name('back.products-finder.reviews.messages.data.index');

    Route::resource('messages', 'MessagesControllerContract', [
        'only' => [
            'index',
        ],
        'as' => 'back.products-finder.reviews',
    ]);
});
