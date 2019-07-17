<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Interface DataControllerContract.
 */
interface DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  string  $service
     *
     * @return JsonResponse
     */
    public function getData(string $service): JsonResponse;

    /**
     * Получаем html таблицы.
     *
     * @param  Request  $request
     * @param  string  $service
     *
     * @return string
     */
    public function getHtml(Request $request, string $service): string;

    /**
     * Получаем настройки datatables.
     *
     * @param  string  $service
     *
     * @return string
     */
    public function getOptions(string $service): string;
}
