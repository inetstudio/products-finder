<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Models;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

/**
 * Interface ProductModelContract.
 */
interface ProductModelContract extends ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable, HasMedia
{
    /**
     * Reload a fresh model instance from the database.
     *
     * @param  array|string  $with
     *
     * @return static|null
     */
    public function fresh($with = []);
}
