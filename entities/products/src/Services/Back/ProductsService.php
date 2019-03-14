<?php

namespace InetStudio\ProductsFinder\Products\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsServiceContract;

/**
 * Class ProductsService.
 */
class ProductsService extends BaseService implements ProductsServiceContract
{
    /**
     * ProductsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return ProductModelContract
     */
    public function save(array $data, int $id): ProductModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $item = $this->saveModel(Arr::only($data, $this->model->getFillable()), $id);

        if (Arr::has($data, ['classifiers'])) {
            $classifiersService = app()->make('InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract');
            $classifiersService->attachToObject(Arr::get($data, 'classifiers'), $item);
        }

        event(app()->makeWith('InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyProductEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Продукт «'.$item->title.'» успешно '.$action);

        return $item;
    }
}
