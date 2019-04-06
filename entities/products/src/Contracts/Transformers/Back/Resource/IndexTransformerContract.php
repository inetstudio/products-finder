<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\Resource;

use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     */
    public function transform(ProductModelContract $item): array;
}
