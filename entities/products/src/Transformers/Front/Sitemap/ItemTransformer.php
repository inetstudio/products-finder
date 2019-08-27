<?php

namespace InetStudio\ProductsFinder\Products\Transformers\Front\Sitemap;

use Illuminate\Support\Carbon;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Transformers\Front\Sitemap\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     */
    public function transform(ProductModelContract $item): array
    {
        /** @var Carbon $updatedAt */
        $updatedAt = $item['updated_at'];

        return [
            'loc' => $item->getMeta('canonical'),
            'lastmod' => $updatedAt->toW3cString(),
            'priority' => '0.7',
            'freq' => 'monthly',
        ];
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
