<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\DataTableServiceContract;

/**
 * Interface DataControllerContract.
 */
interface DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param DataTableServiceContract $dataTableService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $dataTableService): JsonResponse;
}
