<?php

namespace InetStudio\ProductsFinder\Products\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyProductEventContract;

/**
 * Class ModifyProductEvent.
 */
class ModifyProductEvent implements ModifyProductEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyProductEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
