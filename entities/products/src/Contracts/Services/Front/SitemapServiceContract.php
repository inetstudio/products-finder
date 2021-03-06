<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Front;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface SitemapServiceContract.
 */
interface SitemapServiceContract extends BaseServiceContract
{
    /**
     * Возвращаем объекты для карты сайта.
     *
     * @return array
     */
    public function getItems(): array;
}
