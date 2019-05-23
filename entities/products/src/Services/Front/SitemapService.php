<?php

namespace InetStudio\ProductsFinder\Products\Services\Front;

use League\Fractal\Manager;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Front\SitemapServiceContract;

/**
 * Class SitemapService.
 */
class SitemapService extends BaseService implements SitemapServiceContract
{
    /**
     * SitemapService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем информацию по объектам для карты сайта.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getItems(): array
    {
        $productsService = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract'
        );

        $filter = $productsService->prepareFilterByRequestData([]);
        $items = $productsService->getProducts(
            $filter,
            [
                'columns' => ['created_at', 'updated_at'],
            ]
        );

        $transformer = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Transformers\Front\Sitemap\ItemTransformerContract'
        );

        $resource = $transformer->transformCollection($items);

        $manager = new Manager();
        $serializer = app()->make(
            'InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract'
        );
        $manager->setSerializer($serializer);

        $data = $manager->createData($resource)->toArray();

        return $data;
    }
}
