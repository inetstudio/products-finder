<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Contracts\Transformers\Back\Resource;

use InetStudio\Reviews\Messages\Contracts\Models\MessageModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param MessageModelContract $item
     *
     * @return array
     */
    public function transform(MessageModelContract $item): array;
}
