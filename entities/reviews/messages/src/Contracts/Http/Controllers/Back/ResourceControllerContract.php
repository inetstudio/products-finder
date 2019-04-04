<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back;

use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Interface ResourceControllerContract.
 */
interface ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param DataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract;
}
