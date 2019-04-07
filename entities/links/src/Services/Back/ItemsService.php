<?php

namespace InetStudio\ProductsFinder\Links\Services\Back;

use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract;
use InetStudio\ProductsFinder\Links\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  LinkModelContract  $model
     */
    public function __construct(LinkModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return LinkModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): LinkModelContract
    {
        $item = $this->saveModel($data, $id);

        event(
            app()->make(
                'InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
}
