<?php

namespace InetStudio\ProductsFinder\Links\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ProductsFinder\Links\Contracts\Events\Back\ModifyLinkEventContract;

/**
 * Class ModifyLinkEvent.
 */
class ModifyLinkEvent implements ModifyLinkEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyLinkEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
