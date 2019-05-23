<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Transformers\Front\Sitemap;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Interface ItemTransformerContract.
 */
interface ItemTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     */
    public function transform(ProductModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
