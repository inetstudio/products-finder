<?php

namespace InetStudio\ProductsFinder\Links\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Links.
 */
trait Links
{
    /**
     * Отношение "один к одному" с моделью приза.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function links(): HasMany
    {
        $linkModel = app()->make('InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract');

        return $this->hasMany(
            get_class($linkModel),
            'product_id',
            'id'
        );
    }
}
