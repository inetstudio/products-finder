<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем сообщения для поля.
     *
     * @param UtilityServiceContract $utilityService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(UtilityServiceContract $utilityService,
                                    Request $request): SuggestionsResponseContract;
}
