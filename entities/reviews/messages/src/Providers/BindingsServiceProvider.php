<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back\ResourceController',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back\DataController',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Services\Back\DataTableService',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Transformers\Back\Resource\IndexTransformer',
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
