<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter\Filters\Builder;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ClassifiersFilter.
 */
class ClassifiersFilter
{
    /**
     * Применяем фильтр по классификаторам.
     *
     * @param  Builder  $builder
     * @param $value
     *
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        $value = (array) $value;

        $classifiers = [
            'any' => [],
            'all' => [],
        ];

        foreach ($value as $filterValue) {
            if (strpos($filterValue, '+') !== false) {
                $values = explode('+', $filterValue);

                $classifiers['all'][] = $values;
            } else {
                $classifiers['any'][] = $filterValue;
            }
        }

        $builder->withAnyClassifiers($classifiers['any'], 'alias');

        foreach ($classifiers['all'] as $group) {
            $builder->orWhere(function ($query) use ($group) {
                $query->withAllClassifiers($group, 'alias');
            });
        }

        return $builder;
    }
}
