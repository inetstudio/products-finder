<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\MessagesDataTableServiceContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\MessagesControllerContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class MessagesController.
 */
class MessagesController extends Controller implements MessagesControllerContract
{
    /**
     * Список объектов.
     *
     * @param MessagesDataTableServiceContract $datatablesService
     * 
     * @return IndexResponseContract
     */
    public function index(MessagesDataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }
}
