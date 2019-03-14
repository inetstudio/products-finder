<?php

namespace InetStudio\ProductsFinder\Links\Models\Traits;

/**
 * Trait Links.
 */
trait Links
{
    /**
     * Отношение "один к одному" с моделью приза.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function links()
    {
        return $this->hasMany(
            app()->make('InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract'),
            'product_id',
            'id'
        );
    }
}
