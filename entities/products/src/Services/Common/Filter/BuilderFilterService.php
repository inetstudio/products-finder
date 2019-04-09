<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\BuilderFilterServiceContract;

/**
 * Class BuilderFilterService.
 */
class BuilderFilterService implements BuilderFilterServiceContract
{
    /**
     * Применяем фильтры.
     *
     * @param  Builder  $builder
     * @param  array  $filters
     *
     * @return Builder
     */
    public static function apply(Builder $builder, array $filters = []): Builder
    {
        $query = static::applyDecorators($builder, $filters);

        return $query;
    }

    /**
     * Применяем фильтры.
     *
     * @param  Builder  $builder
     * @param  array  $filters
     *
     * @return Builder
     */
    protected static function applyDecorators(Builder $builder, array $filters = []): Builder
    {
        foreach ($filters as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $builder = $decorator::apply($builder, $value);
            }
        }

        return $builder;
    }

    /**
     * Возвращаем класс фильтра.
     *
     * @param string $name
     *
     * @return string
     */
    protected static function createFilterDecorator(string $name): string
    {
        return __NAMESPACE__.'\\Filters\\Builder\\'.
            str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', $name))
            );
    }

    /**
     * Проверяем существование фильтра.
     *
     * @param string $decorator
     *
     * @return boolean
     */
    protected static function isValidDecorator(string $decorator): bool
    {
        return class_exists($decorator);
    }
}