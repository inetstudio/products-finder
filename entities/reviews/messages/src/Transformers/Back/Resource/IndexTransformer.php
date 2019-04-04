<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\Reviews\Messages\Contracts\Models\MessageModelContract;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param MessageModelContract $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(MessageModelContract $item): array
    {
        return [
            'checkbox' => view('admin.module.reviews.messages::back.partials.datatables.checkbox', [
                'id' => $item['id'],
            ])->render(),
            'id' => (int) $item['id'],
            'read' => view('admin.module.reviews.messages::back.partials.datatables.read', [
                'is_read' => $item['is_read'],
            ])->render(),
            'active' => view('admin.module.reviews.messages::back.partials.datatables.active', [
                'id' => $item['id'],
                'is_active' => $item['is_active'],
            ])->render(),
            'name' => $item['name'],
            'email' => $item['email'],
            'media' => view('admin.module.reviews.messages::back.partials.datatables.media', compact('item'))
                ->render(),
            'title' => $item['title'],
            'message' => $item['message'],
            'rating' => (int) $item['rating'],
            'created_at' => (string) $item['created_at'],
            'product' => view('admin.module.products-finder.reviews.messages::back.partials.datatables.product', [
                'item' => $item['reviewable'],
            ])->render(),
            'actions' => view('admin.module.reviews.messages::back.partials.datatables.actions', [
                'id' => $item['id'],
            ])->render(),
        ];
    }
}
