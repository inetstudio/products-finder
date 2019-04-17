<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource;

use Illuminate\View\View;
use Illuminate\Http\Request;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * IndexResponse constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param  Request  $request
     *
     * @return View
     */
    public function toResponse($request)
    {
        return view('admin.module.products-finder.products::back.pages.index', $this->data);
    }
}
