<?php

namespace InetStudio\ProductsFinder\Classifiers\Entries\Contracts\Services\Back;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;

/**
 * Interface DataTableServiceContract.
 */
interface DataTableServiceContract
{
    /**
     * @return Builder
     */
    public function html(): Builder;

    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     */
    public function ajax(): JsonResponse;

    /**
     * Запрос в бд для получения данных для формирования таблицы.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query();
}
