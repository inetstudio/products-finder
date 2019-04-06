<?php

namespace InetStudio\ProductsFinder\Products\Http\Responses\Back\Utility;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class SuggestionsResponse.
 */
class SuggestionsResponse implements SuggestionsResponseContract, Responsable
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * @var string
     */
    protected $type;

    /**
     * SuggestionsResponse constructor.
     *
     * @param  Collection  $items
     * @param  string  $type
     */
    public function __construct(Collection $items, string $type = '')
    {
        $this->items = $items;
        $this->type = $type;
    }

    /**
     * Возвращаем slug по заголовку объекта.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     *
     * @throws BindingResolutionException
     */
    public function toResponse($request)
    {
        $resource = (app()->make('InetStudio\ProductsFinder\Products\Contracts\Transformers\Back\Utility\SuggestionTransformerContract',
            [
                'type' => $this->type,
            ]))->transformCollection($this->items);

        $serializer = app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract');

        $manager = new Manager();
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        $data = [
            'suggestions' => [],
            'items' => [],
        ];

        if ($this->type == 'autocomplete') {
            $data['suggestions'] = $transformation;
        } else {
            $data['items'] = $transformation;
        }

        return response()->json($data);
    }
}
