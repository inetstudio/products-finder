<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract;

/**
 * Class FormResponse.
 */
class FormResponse implements FormResponseContract, Responsable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * FormResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии формы объекта.
     *
     * @param Request $request
     *
     * @return View
     */
    public function toResponse($request)
    {
        return view('admin.module.products-finder.products::back.pages.form', $this->data);
    }
}
