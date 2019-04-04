<?php

namespace InetStudio\ProductsFinder\Products\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var ProductModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param ProductModelContract $item
     */
    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }
}
