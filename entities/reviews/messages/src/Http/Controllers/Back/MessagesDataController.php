<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\MessagesDataTableServiceContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Controllers\Back\MessagesDataControllerContract;

/**
 * Class MessagesDataController.
 */
class MessagesDataController extends Controller implements MessagesDataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param MessagesDataTableServiceContract $datatablesService
     *
     * @return mixed
     */
    public function data(MessagesDataTableServiceContract $datatablesService)
    {
        return $datatablesService->ajax();
    }
}
