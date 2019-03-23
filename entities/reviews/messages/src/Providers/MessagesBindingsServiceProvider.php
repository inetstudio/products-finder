<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class MessagesBindingsServiceProvider.
 */
class MessagesBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\MessagesControllerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back\MessagesController',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\MessagesDataControllerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back\MessagesDataController',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\MessagesDataTableServiceContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Services\Back\MessagesDataTableService',
        'InetStudio\ProductsFinder\Reviews\Messages\Contracts\Transformers\Back\MessageTransformerContract' => 'InetStudio\ProductsFinder\Reviews\Messages\Transformers\Back\MessageTransformer',
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
