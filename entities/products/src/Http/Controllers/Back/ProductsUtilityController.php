<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsServiceContract;
use InetStudio\ProductsFinder\Products\Http\Responses\Back\Utility\SuggestionsResponse;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsUtilityControllerContract;

/**
 * Class ProductsUtilityController.
 */
class ProductsUtilityController extends Controller implements ProductsUtilityControllerContract
{
    /**
     * Возвращаем призы для поля.
     *
     * @param ProductsServiceContract $productsService
     * @param Request $request
     *
     * @return SuggestionsResponse
     */
    public function getSuggestions(ProductsServiceContract $productsService, Request $request): SuggestionsResponse
    {
        $search = $request->get('q');
        $type = $request->get('type') ?? '';

        $suggestions = $productsService->getSuggestions($search);

        return app()->makeWith(SuggestionsResponse::class,
            compact('suggestions', 'type')
        );
    }
}
