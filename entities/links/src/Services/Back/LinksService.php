<?php

namespace InetStudio\ProductsFinder\Links\Services\Back;

use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract;
use InetStudio\ProductsFinder\Links\Contracts\Services\Back\LinksServiceContract;

/**
 * Class LinksService.
 */
class LinksService extends BaseService implements LinksServiceContract
{
    /**
     * LinksService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return LinkModelContract
     */
    public function save(array $data, int $id): LinkModelContract
    {
        $item = $this->saveModel($data, $id);

        event(app()->makeWith('InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyLinkEventContract', [
            'object' => $item,
        ]));

        return $item;
    }
}
