<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Front;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract
{
    /**
     * Получаем отфильтрованный builder.
     *
     * @param  Builder  $builder
     * @param  array  $filter
     *
     * @return Builder
     */
    public function getFilterBuilder(Builder $builder, array $filter): Builder;

    /**
     * Получаем фильтр по умолчанию.
     *
     * @return array
     */
    public function getDefaultFilters(): array;

    /**
     * Формируем фильтр по запросу.
     *
     * @param  array  $data
     *
     * @return array
     */
    public function prepareFilterByRequestData(array $data): array;

    /**
     * Область и тип продукта (из категории) по типам продукта.
     *
     * @param  array  $item
     *
     * @return array
     */
    public function getProductBreadcrumbs(array $item): array;

    /**
     * Применяем фильтры к продукту.
     *
     * @param  array  $item
     * @param  array  $filter
     *
     * @return bool
     */
    public function applyFiltersForItem(array $item, array $filter): bool;
}
