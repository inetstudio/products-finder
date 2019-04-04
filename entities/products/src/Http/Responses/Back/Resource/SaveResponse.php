<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var ProductModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param ProductModelContract $item
     */
    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->redirectToRoute('back.products-finder.products.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
