<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class UtilityController.
 */
class UtilityController extends Controller implements UtilityControllerContract
{
    /**
     * Возвращаем продукты для поля.
     *
     * @param UtilityServiceContract $utilityService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     *
     * @throws BindingResolutionException
     */
    public function getSuggestions(UtilityServiceContract $utilityService,
                                    Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q', '');
        $type = $request->get('type', '');

        $items = $utilityService->getSuggestions($search);

        return app()->make(SuggestionsResponseContract::class, compact('items', 'type'));
    }
}
