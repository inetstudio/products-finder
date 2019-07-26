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

        $classifiers = [
            'any' => [],
            'all' => [],
        ];

        foreach ($filter as $filterValue) {
            if (strpos($filterValue, '+') !== false) {
                $values = explode('+', $filterValue);

                $classifiers['all'][] = $values;
            } else {
                $classifiers['any'][] = $filterValue;
            }
        }

        if (count(array_intersect($classifiers['any'], $types)) > 0) {
            return true;
        }

        foreach ($classifiers['all'] as $group) {
            if (count(array_intersect($group, $types)) == count($group)) {
                return true;
            }
        }

        return false;
    }
}
