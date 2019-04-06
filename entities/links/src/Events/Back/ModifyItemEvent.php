<?php

namespace InetStudio\ProductsFinder\Links\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract;
use InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var LinkModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  LinkModelContract  $item
     */
    public function __construct(LinkModelContract $item)
    {
        $this->item = $item;
    }
}
