<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class EntriesBindingsServiceProvider.
 */
class EntriesBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesControllerContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back\EntriesController',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesDataControllerContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back\EntriesDataController',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\EntriesDataTableServiceContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Services\Back\EntriesDataTableService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
