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
     * @return bool
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
     * @return bool
     */
    protected static function applyDecorators($item, string $filterType, array $filters = []): bool
    {
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

        return static::analyzeResult($checks, $filterType);
    }

    /**
     * Анализ фильтров.
     *
     * @param  array  $checks
     * @param  string  $filterType
     *
     * @return bool
     */
    protected static function analyzeResult(array $checks, string $filterType): bool
    {
        if (empty($checks)) {
            return true;
        }

        $checks = array_unique($checks);

        switch ($filterType) {
            case 'or':
                $result = array_sum($checks);

                break;
            case 'and':
                $result = array_product($checks);

                break;
            default:
                $result = 0;
        }

        return $result > 0;
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
        ).'Filter';
    }

    /**
     * Проверяем существование фильтра.
     *
     * @param  string  $decorator
     *
     * @return bool
     */
    protected static function isValidDecorator(string $decorator): bool
    {
        return class_exists($decorator);
    }
}
