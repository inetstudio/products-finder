<?php

namespace InetStudio\ProductsFinder\Products\Providers;

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
        'InetStudio\ProductsFinder\Products\Contracts\Console\Commands\ProcessFeedsCommandContract' => 'InetStudio\ProductsFinder\Products\Console\Commands\ProcessFeedsCommand',
        'InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ProductsFinder\Products\Events\Back\ModifyItemEvent',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\ResourceController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\DataController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\UtilityController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\ProductsFinder\Products\Http\Requests\Back\SaveItemRequest',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Managers\FilterServicesManagerContract' => 'InetStudio\ProductsFinder\Products\Managers\FilterServicesManager',
        'InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract' => 'InetStudio\ProductsFinder\Products\Models\ProductModel',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Back\DataTableService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Back\ItemsService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Back\UtilityService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\BuilderFilterServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Common\Filter\BuilderFilterService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\ModelFilterServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Common\Filter\ModelFilterService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Front\ItemsService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Front\SitemapServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Front\SitemapService',
        'InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ProductsFinder\Products\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\ProductsFinder\Products\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\ProductsFinder\Products\Contracts\Transformers\Front\Sitemap\ItemTransformerContract' => 'InetStudio\ProductsFinder\Products\Transformers\Front\Sitemap\ItemTransformer',
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
