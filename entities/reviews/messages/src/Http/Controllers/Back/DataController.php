<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $datatablesService): JsonResponse
    {
        return $datatablesService->ajax();
    }
}
