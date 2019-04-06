<?php

Route::group([
    'namespace' => 'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back/products-finder/classifiers',
], function() {
    Route::any('entries/data', 'EntriesDataControllerContract@data')->name('back.products-finder.classifiers.entries.data.index');

    Route::resource('entries', 'EntriesControllerContract', [
        'only' => [
            'index',
        ],
        'as' => 'back.products-finder.classifiers',
    ]);
});
