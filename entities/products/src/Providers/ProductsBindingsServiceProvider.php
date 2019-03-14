<?php

namespace InetStudio\ProductsFinder\Products\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ProductsBindingsServiceProvider.
 */
class ProductsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyProductEventContract' => 'InetStudio\ProductsFinder\Products\Events\Back\ModifyProductEvent',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\ProductsController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsDataControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\ProductsDataController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsUtilityControllerContract' => 'InetStudio\ProductsFinder\Products\Http\Controllers\Back\ProductsUtilityController',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveProductRequestContract' => 'InetStudio\ProductsFinder\Products\Http\Requests\Back\SaveProductRequest',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ProductsFinder\Products\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract' => 'InetStudio\ProductsFinder\Products\Models\ProductModel',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsDataTableServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Back\ProductsDataTableService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Back\ProductsService',
        'InetStudio\ProductsFinder\Products\Contracts\Services\Front\ProductsServiceContract' => 'InetStudio\ProductsFinder\Products\Services\Front\ProductsService',
        'InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\ProductTransformerContract' => 'InetStudio\ProductsFinder\Products\Transformers\Back\ProductTransformer',
        'InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\SuggestionTransformerContract' => 'InetStudio\ProductsFinder\Products\Transformers\Back\SuggestionTransformer',
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
