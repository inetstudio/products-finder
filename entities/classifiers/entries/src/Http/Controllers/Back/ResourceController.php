<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return IndexResponseContract
     *
     * @throws BindingResolutionException
     */
    public function index(DataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return $this->app->make(
            IndexResponseContract::class, [
                'data' => compact('table'),
            ]
        );
    }
}
