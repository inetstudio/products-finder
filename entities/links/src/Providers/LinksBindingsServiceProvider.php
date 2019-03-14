<?php

namespace InetStudio\ProductsFinder\Links\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class LinksBindingsServiceProvider.
 */
class LinksBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyLinkEventContract' => 'InetStudio\ProductsFinder\Links\Events\Back\ModifyLinkEvent',
        'InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract' => 'InetStudio\ProductsFinder\Links\Models\LinkModel',
        'InetStudio\ProductsFinder\Links\Contracts\Services\Back\LinksServiceContract' => 'InetStudio\ProductsFinder\Links\Services\Back\LinksService',
        'InetStudio\ProductsFinder\Links\Contracts\Services\Front\LinksServiceContract' => 'InetStudio\ProductsFinder\Links\Services\Front\LinksService',
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
