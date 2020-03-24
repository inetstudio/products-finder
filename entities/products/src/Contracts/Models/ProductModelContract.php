<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface ProductModelContract.
 */
interface ProductModelContract extends BaseModelContract, Auditable, HasMedia
{
}
