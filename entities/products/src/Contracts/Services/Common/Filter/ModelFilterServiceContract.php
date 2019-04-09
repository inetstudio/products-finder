<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter;

/**
 * Interface ModelFilterServiceContract.
 */
interface ModelFilterServiceContract
{
    /**
     * Применяем фильтры.
     *
     * @param  $item
     * @param  string $filterType
     * @param  array  $filters
     *
     * @return boolean
     */
    public static function apply($item, string $filterType, array $filters = []): bool;
}
