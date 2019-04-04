<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back;

use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

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
