<?php

namespace InetStudio\ProductsFinder\Products\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return ProductModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): ProductModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        if (Arr::has($data, ['classifiers'])) {
            $classifiersService = app()->make(
                'InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract'
            );
            $classifiersService->attachToObject(Arr::get($data, 'classifiers'), $item);
        }

        event(
            app()->makeWith(
                'InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Продукт «'.$item->title.'» успешно '.$action);

        return $item;
    }
}
