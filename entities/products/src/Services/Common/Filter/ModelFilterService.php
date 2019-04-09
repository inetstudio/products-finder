<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter;

use InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\ModelFilterServiceContract;

/**
 * Class ModelFilterService.
 */
class ModelFilterService implements ModelFilterServiceContract
{
    /**
     * Применяем фильтры.
     *
     * @param  $item
     * @param  string  $filterType
     * @param  array  $filters
     *
     * @return boolean
     */
    public static function apply($item, string $filterType = 'or', array $filters = []): bool
    {
        $result = static::applyDecorators($item, $filterType, $filters);

        return $result;
    }

    /**
     * Применяем фильтры.
     *
     * @param  $item
     * @param  string  $filterType
     * @param  array  $filters
     *
     * @return boolean
     */
    protected static function applyDecorators($item, string $filterType, array $filters = []): bool
    {
        $result = false;

        $checks = [];

        foreach ($filters as $filterName => $value) {
            if (empty($value)) {
                continue;
            }

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $checks[] = $decorator::apply($item, $value);
            }
        }

        if (empty($checks)) {
            return true;
        }

        $checks = array_unique($checks);

        switch ($filterType) {
            case 'or':
                $result = count($checks) > 1 || (count($checks) == 1 && $checks[0] === true);

                break;
            case 'and':
                $result = (count($checks) == 1 && $checks[0] === true);

                break;
        }

        return $result;
    }

    /**
     * Возвращаем класс фильтра.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected static function createFilterDecorator(string $name): string
    {
        return __NAMESPACE__.'\\Filters\\Model\\'.str_replace(
            ' ',
            '',
            ucwords(str_replace('_', ' ', $name))
        );
    }

    /**
     * Проверяем существование фильтра.
     *
     * @param  string  $decorator
     *
     * @return boolean
     */
    protected static function isValidDecorator(string $decorator): bool
    {
        return class_exists($decorator);
    }
}