<?php

namespace InetStudio\ProductsFinder\Links\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return LinkModelContract
     */
    public function save(array $data, int $id): LinkModelContract;
}
