<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter\Filters\Model;

/**
 * Class ClassifiersFilter.
 */
class ClassifiersFilter
{
    /**
     * Применяем фильтр по классификаторам.
     *
     * @param  $item
     * @param  array  $filter
     *
     * @return bool
     */
    public static function apply($item, array $filter): bool
    {
        $types = collect($item['classifiers'])->collapse()->pluck('alias')->toArray();

        return count(array_intersect($filter, $types)) > 0;
    }
}
