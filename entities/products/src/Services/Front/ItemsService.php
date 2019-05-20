<?php

namespace InetStudio\ProductsFinder\Products\Services\Front;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Favorites\Services\Front\Traits\FavoritesServiceTrait;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    use FavoritesServiceTrait;

    /**
     * @var string
     */
    protected $favoritesType = 'products_finder';

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
        $filter = [
            'additional' => [],
            'main' => [],
        ];

        collect($this->categories)->pluck('types')
            ->flatten(1)
            ->each(
                function ($item) use (&$filter) {
                    $mode = $item['mode'] ?? 'main';

                    if ($mode == 'main') {
                        $filter[$mode] = array_merge_recursive($item['filter'], $filter[$mode]);
                    }
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
        $filter = [
            'additional' => [],
            'main' => [],
        ];

        $scopeParam = Arr::get($data, 'scope', -1);
        $typeParam = Arr::get($data, 'type', '');

        if ($scopeParam === -1 && $typeParam === '') {
            $filter = array_merge_recursive($filter, $data);

            return $filter;
        }

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
            ->each(
                function ($item) use (&$filter) {
                    $mode = $item['mode'] ?? 'main';

                    if ($mode == 'main') {
                        $filter[$mode] = array_merge_recursive($item['filter'], $filter[$mode]);
                    }
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
                if ((($type['mode'] ?? 'main') == 'main') && $filterService->apply($item, 'or', $type['filter'])) {
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
