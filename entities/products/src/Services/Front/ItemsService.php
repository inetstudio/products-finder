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

            return Arr::only($filter, ['additional', 'main']);
        }

        $typeCategories = collect($this->categories)->pluck('types')
            ->flatten(1)
            ->filter(
                function ($value) use ($typeParam) {
                    $key = md5(json_encode($value['filter']));

                    return $typeParam == $key;
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

        return Arr::only($filter, ['additional', 'main']);
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
                            'key' => md5(json_encode($type['filter'])),
                        ],
                    ];
                }
            }

            $scopeIndex++;
        }

        return [];
    }

    /**
     * Получаем продукты.
     *
     * @param  array  $filter
     * @param  array  $params
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function getProducts(array $filter = [], array $params = [])
    {
        $filterService = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Managers\FilterServicesManagerContract'
        )->with('builder');

        $defaultParams = [
            'columns' => ['created_at'],
            'relations' => ['media'],
            'order' => ['created_at' => 'DESC'],
        ];

        $filter = (empty($filter['main']) && empty($filter['additional']))
            ? $this->getDefaultFilters()
            : $this->prepareFilterByRequestData($filter);

        $query = $this->getModel()::buildQuery(array_merge($defaultParams, $params));
        $mainFilterQuery = $filterService->apply($query, $filter['main']);
        $items = $filterService->apply($mainFilterQuery, $filter['additional'])->get();

        return $items;
    }
}
