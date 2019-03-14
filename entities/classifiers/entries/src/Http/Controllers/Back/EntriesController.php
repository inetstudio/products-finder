<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\EntriesDataTableServiceContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesControllerContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class EntriesController.
 */
class EntriesController extends Controller implements EntriesControllerContract
{
    /**
     * Список объектов.
     *
     * @param EntriesDataTableServiceContract $datatablesService
     * 
     * @return IndexResponseContract
     */
    public function index(EntriesDataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }
}
