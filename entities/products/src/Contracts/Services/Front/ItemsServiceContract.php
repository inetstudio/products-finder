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
     * Получаем продукты.
     *
     * @param  array  $filter
     * @param  array  $params
     *
     * @return mixed
     */
    public function getProducts(array $filter = [], array $params = []);
}
