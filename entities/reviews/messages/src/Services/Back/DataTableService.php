<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Services\Back;

use Exception;
use Throwable;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\Reviews\Messages\Contracts\Models\MessageModelContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Services\Back\DataTableServiceContract;

/**
 * Class DataTableService.
 */
class DataTableService extends DataTable implements DataTableServiceContract
{
    /**
     * @var MessageModelContract
     */
    public $model;

    /**
     * DataTableService constructor.
     *
     * @param  MessageModelContract  $model
     */
    public function __construct(MessageModelContract $model)
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
        $transformer = app()->make('InetStudio\ProductsFinder\Reviews\Messages\Contracts\Transformers\Back\Resource\IndexTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['groups', 'actions'])
            ->make();
    }

    /**
     * Запрос в бд для получения данных для формирования таблицы.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery([
            'columns' => ['title', 'rating', 'created_at'],
        ])->where('reviewable_type', '=', 'InetStudio\ProductsFinder\Products\Models\ProductModel');

        return $query;
    }

    /**
     * Генерация таблицы.
     *
     * @return Builder
     *
     * @throws Throwable
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
     *
     * @throws Throwable
     */
    protected function getColumns(): array
    {
        return [
            [
                'data' => 'checkbox',
                'name' => 'checkbox',
                'title' => view('admin.module.reviews.messages::back.partials.datatables.checkbox')
                    ->render(),
                'orderable' => false,
                'searchable' => false,
            ],
            ['data' => 'read', 'name' => 'is_read', 'title' => 'Прочитано', 'searchable' => false],
            ['data' => 'active', 'name' => 'is_active', 'title' => 'Активность', 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Имя'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'media', 'name' => 'media', 'title' => 'Медиа', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'name' => 'title', 'title' => 'Заголовок'],
            ['data' => 'message', 'name' => 'message', 'title' => 'Отзыв'],
            ['data' => 'rating', 'name' => 'rating', 'title' => 'Рейтинг'],
            [
                'data' => 'product',
                'name' => 'product',
                'title' => 'Продукт',
                'orderable' => false,
                'searchable' => false
            ],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false
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
            'url' => route('back.products-finder.reviews.messages.data.index'),
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
        $i18n = trans('admin::datatables');

        return [
            'order' => [10, 'desc'],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $i18n,
        ];
    }
}
