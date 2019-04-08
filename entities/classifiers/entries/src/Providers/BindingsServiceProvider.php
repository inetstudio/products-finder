<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var array
     */
    public $bindings = [
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back\ResourceController',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back\DataController',
        'InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ProductsFinder\Classifiers\Entries\Services\Back\DataTableService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
