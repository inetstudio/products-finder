<?php

namespace InetStudio\ProductsFinder\Products\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Front\FeedsServiceContract;

/**
 * Class FeedsService.
 */
class FeedsService extends BaseService implements FeedsServiceContract
{
    /**
     * FeedsService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }
}
