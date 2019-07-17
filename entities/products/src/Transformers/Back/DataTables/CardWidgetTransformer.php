<?php

namespace InetStudio\ProductsFinder\Products\Transformers\Back\DataTables;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\DataTables\CardWidgetTransformerContract;

/**
 * Class CardWidgetTransformer.
 */
class CardWidgetTransformer extends TransformerAbstract implements CardWidgetTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(ProductModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'preview' => view(
                'admin.module.products-finder.products::back.partials.datatables.preview',
                compact('item')
            )->render(),
            'brand' => $item['brand'],
            'title' => $item['title'],
            'actions' => view(
                'admin.module.products-finder.products::back.partials.datatables.modal_actions',
                compact('item')
            )->render(),
        ];
    }
}
