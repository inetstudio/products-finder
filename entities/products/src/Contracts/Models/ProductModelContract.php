<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;
use InetStudio\Favorites\Contracts\Models\Traits\FavoritableContract;

/**
 * Interface ProductModelContract.
 */
interface ProductModelContract extends BaseModelContract, Auditable, FavoritableContract, HasMedia
{
}
