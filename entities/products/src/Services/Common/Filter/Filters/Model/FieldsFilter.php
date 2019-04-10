<?php

namespace InetStudio\ProductsFinder\Products\Services\Common\Filter\Filters\Model;

use Illuminate\Support\Str;

/**
 * Class FieldsFilter.
 */
class FieldsFilter
{
    /**
     * Применяем фильтр по полям.
     *
     * @param  $item
     * @param  array  $filter
     *
     * @return bool
     */
    public static function apply($item, array $filter): bool
    {
        foreach ($filter as $fieldExpression) {
            $field = strtok($fieldExpression, '|');
            $operator = strtok('|');
            $value = Str::lower(strtok('|'));

            $itemFieldValue = Str::lower($item[$field] ?? '');

            $passed = false;

            switch ($operator) {
                case '=':
                    $passed = ($itemFieldValue == $value);
                    break;
                case 'like':
                    $passed = (strpos($itemFieldValue, str_replace('%', '', $value)) !== false);
                    break;
            }

            if ($passed) {
                return true;
            }
        }

        return false;
    }
}
