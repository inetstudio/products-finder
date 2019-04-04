<?php

namespace InetStudio\ProductsFinder\Reviews\Messages\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\ProductsFinder\Reviews\Messages\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract, Responsable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * IndexResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function toResponse($request)
    {
        return view('admin.module.products-finder.reviews.messages::back.pages.index', $this->data);
    }
}
