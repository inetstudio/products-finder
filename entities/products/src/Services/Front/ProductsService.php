<?php

namespace InetStudio\ProductsFinder\Products\Services\Front;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\ProductsFinder\Products\Contracts\Services\Front\ProductsServiceContract;

/**
 * Class ProductsService.
 */
class ProductsService extends BaseService implements ProductsServiceContract
{
    /**
     * @var
     */
    public $categories;

    /**
     * ProductsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract'));
    }

    /**
     * Получаем отфильтрованный builder.
     *
     * @param Builder $builder
     * @param array $filter
     *
     * @return mixed
     */
    public function getFilterBuilder(Builder $builder, array $filter)
    {
        $filter = (empty($filter)) ? $this->getDefaultFilters() : $filter;

        if (isset($filter['classifiers']) && !empty($filter['classifiers'])) {
            $builder->withAnyClassifiers($filter['classifiers'], 'alias');
        }

        foreach ($filter['fields'] ?? [] as $fieldExpression) {
            $field = strtok($fieldExpression, '|');
            $operator = strtok('|');
            $value = strtok('|');

            $builder->orWhere($field, $operator, $value);
        }

        return $builder;
    }

    /**
     * Получаем фильтр по умолчанию.
     *
     * @return array
     */
    public function getDefaultFilters(): array
    {
        $filter = [];

        foreach ($this->categories ?? [] as $scope => $scopeData) {
            foreach ($scopeData['types'] ?? [] as $type) {
                foreach ($type['filter'] as $filterType => $filters) {
                    foreach ($filters as $typeFilter) {
                        $filter[$filterType][] = $typeFilter;
                    }
                }
            }
        }

        return $filter;
    }

    /**
     * Формируем фильтр по запросу.
     *
     * @param array $data
     *
     * @return array
     */
    public function prepareFilterByRequestData(array $data): array
    {
        $filter = [];

        $scopeParam = Arr::get($data, 'scope', -1);
        $typeParam = Arr::get($data, 'type', '');

        $scopeIndex = 0;
        foreach ($this->categories ?? [] as $scope => $scopeData) {
            foreach ($scopeData['types'] ?? [] as $type) {
                if ($scopeIndex == $scopeParam || in_array($typeParam, (array)$type['alias'])) {
                    foreach ($type['filter'] as $filterType => $filters) {
                        foreach ($filters as $typeFilter) {
                            $filter[$filterType][] = $typeFilter;
                        }
                    }
                }
            }

            $scopeIndex++;
        }

        return $filter;
    }

    /**
     * Область и тип продукта (из категории) по типам продукта.
     *
     * @param array $item
     *
     * @return array
     */
    public function getProductBreadcrumbs(array $item): array
    {
        $scopeIndex = 0;
        foreach ($this->categories ?? [] as $scope => $scopeData) {
            foreach ($scopeData['types'] ?? [] as $type) {
                if ($this->applyFiltersForItem($item, $type['filter'])) {
                    return [
                        'scope' => [
                            'title' => $scope,
                            'index' => $scopeIndex,
                        ],
                        'type' => [
                            'title' => $type['title'],
                            'alias' => $type['alias'],
                        ],
                    ];
                }
            }
            $scopeIndex++;
        }

        return [];
    }

    /**
     * Применяем фильтры к продукту.
     *
     * @param $item
     * @param $filter
     *
     * @return bool
     */
    protected function applyFiltersForItem($item, $filter): bool
    {
        if (isset($filter['classifiers']) && !empty($filter['classifiers'])) {
            $types = collect($item['classifiers']['products_finder_types'])->pluck('alias')->toArray();

            if (count(array_intersect($filter['classifiers'], $types)) > 0) {
                return true;
            }
        }

        foreach ($filter['fields'] ?? [] as $fieldExpression) {
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
