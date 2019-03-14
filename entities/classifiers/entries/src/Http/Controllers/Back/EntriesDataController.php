<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\EntriesDataTableServiceContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesDataControllerContract;

/**
 * Class EntriesDataController.
 */
class EntriesDataController extends Controller implements EntriesDataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param EntriesDataTableServiceContract $datatablesService
     *
     * @return mixed
     */
    public function data(EntriesDataTableServiceContract $datatablesService)
    {
        return $datatablesService->ajax();
    }
}
