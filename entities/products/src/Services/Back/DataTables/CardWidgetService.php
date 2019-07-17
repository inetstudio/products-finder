<?php

namespace InetStudio\ProductsFinder\Products\Services\Back\DataTables;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\DataTables\CardWidgetServiceContract;

/**
 * Class CardWidgetService.
 */
class CardWidgetService extends DataTable implements CardWidgetServiceContract
{
    /**
     * @var ProductModelContract
     */
    public $model;

    /**
     * CardWidgetService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        $transformer = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\DataTables\CardWidgetTransformerContract'
        );

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['preview', 'actions'])
            ->make();
    }

    /**
     * Запрос в бд для получения данных для формирования таблицы.
     *
     * @return EloquentBuilder
     */
    public function query()
    {
        $query = $this->model->buildQuery();

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            [
                'data' => 'preview',
                'name' => 'preview',
                'title' => 'Изображение',
                'orderable' => false,
                'searchable' => false,
            ],
            ['data' => 'brand', 'name' => 'brand', 'title' => 'Бренд'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Название'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
            ],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.products-finder.products.datatables.data', ['service' => 'card-widget']),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [1, 'asc'],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
