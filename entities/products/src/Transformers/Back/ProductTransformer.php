<?php

namespace InetStudio\ProductsFinder\Products\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\ProductTransformerContract;

/**
 * Class ProductTransformer.
 */
class ProductTransformer extends TransformerAbstract implements ProductTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param ProductModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(ProductModelContract $item): array
    {
        return [
            'id' => (int) $item->id,
            'preview' => view('admin.module.products-finder.products::back.partials.datatables.preview',
                compact('item')
            )->render(),
            'brand' => $item->brand,
            'title' => $item->title,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'actions' => view('admin.module.products-finder.products::back.partials.datatables.actions', [
                'id' => $item->id,
            ])->render(),
        ];
    }
}
