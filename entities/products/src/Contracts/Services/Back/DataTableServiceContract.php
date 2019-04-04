<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Back;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

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
     * @return EloquentBuilder|QueryBuilder|Collection
     */
    public function query();
}
