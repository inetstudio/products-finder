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

        return $builder->withAnyClassifiers($value, 'alias');
    }
}
