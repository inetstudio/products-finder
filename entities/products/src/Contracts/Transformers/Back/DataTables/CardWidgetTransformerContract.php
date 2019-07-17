<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\DataTables;

use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Interface CardWidgetTransformerContract.
 */
interface CardWidgetTransformerContract
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
