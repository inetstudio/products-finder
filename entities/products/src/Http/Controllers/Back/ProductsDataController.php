<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsDataTableServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsDataControllerContract;

/**
 * Class ProductsDataController.
 */
class ProductsDataController extends Controller implements ProductsDataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param ProductsDataTableServiceContract $dataTableService
     *
     * @return mixed
     */
    public function data(ProductsDataTableServiceContract $dataTableService)
    {
        return $dataTableService->ajax();
    }
}
