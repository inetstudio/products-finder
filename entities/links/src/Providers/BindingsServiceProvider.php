<?php

namespace InetStudio\ProductsFinder\Links\Providers;

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
        'InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ProductsFinder\Links\Events\Back\ModifyItemEvent',
        'InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract' => 'InetStudio\ProductsFinder\Links\Models\LinkModel',
        'InetStudio\ProductsFinder\Links\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ProductsFinder\Links\Services\Back\ItemsService',
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
