<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter\Filters\Builder;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldsFilter.
 */
class FieldsFilter
{
    /**
     * Применяем фильтр по полям.
     *
     * @param  Builder  $builder
     * @param $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        foreach ($value ?? [] as $fieldExpression) {
            $field = strtok($fieldExpression, '|');
            $operator = strtok('|');
            $value = strtok('|');

            $value = preg_replace('/[^%A-Za-zА-Яа-я\-\(\) ]+/u', '', $value);

            $builder->orWhere($field, $operator, $value);
        }

        return $builder;
    }
}