<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Front;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract
{
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
