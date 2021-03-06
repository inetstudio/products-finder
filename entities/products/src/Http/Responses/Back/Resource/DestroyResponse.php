<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class DestroyResponse.
 */
class DestroyResponse implements DestroyResponseContract
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * DestroyResponse constructor.
     *
     * @param  bool  $result
     */
    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при удалении объекта.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => $this->result,
            ]
        );
    }
}
