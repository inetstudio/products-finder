<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var ProductModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  ProductModelContract  $item
     */
    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function toResponse($request)
    {
        $item = $this->item->fresh();

        return response()->redirectToRoute(
            'back.products-finder.products.edit', [
                $item['id'],
            ]
        );
    }
}
