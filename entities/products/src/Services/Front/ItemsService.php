<?php

namespace InetStudio\ProductsFinder\Products\Services\Front;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * @var array
     */
    public $categories = [];

    /**
     * ItemsService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем фильтр по умолчанию.
     *
     * @return array
     */
    public function getDefaultFilters(): array
    {
        $filter = [];

        collect($this->categories)->pluck('types')
            ->flatten(1)
            ->pluck('filter')
            ->each(
                function ($item) use (&$filter) {
                    $filter = array_merge_recursive($item, $filter);
                }
            );

        return $filter;
    }

    /**
     * Формируем фильтр по запросу.
     *
     * @param  array  $data
     *
     * @return array
     */
    public function prepareFilterByRequestData(array $data): array
    {
        $filter = [];

        $scopeParam = Arr::get($data, 'scope', -1);
        $typeParam = Arr::get($data, 'type', '');

        $typeCategories = collect($this->categories)->pluck('types')
            ->flatten(1)
            ->filter(
                function ($value) use ($typeParam) {
                    return in_array($typeParam, (array) $value['alias']);
                }
            );

        $scopeCategories = collect($this->categories)->values()->get($scopeParam);
        $scopeCategories = ($scopeCategories) ? collect($scopeCategories)->flatten(1) : collect([]);

        $typeCategories->merge($scopeCategories)
            ->unique()
            ->pluck('filter')
            ->each(
                function ($item) use (&$filter) {
                    $filter = array_merge_recursive($item, $filter);
                }
            );

        return $filter;
    }

    /**
     * Область и тип продукта (из категории) по типам продукта.
     *
     * @param  array  $item
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getProductBreadcrumbs(array $item): array
    {
        $filterService = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Managers\FilterServicesManagerContract'
        )->with('model');

        $scopeIndex = 0;

        foreach ($this->categories as $scope => $scopeData) {
            foreach ($scopeData['types'] ?? [] as $type) {
                if ($filterService->apply($item, 'or', $type['filter'])) {
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
}
