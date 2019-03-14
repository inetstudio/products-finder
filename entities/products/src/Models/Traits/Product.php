<?php

namespace InetStudio\ProductsFinder\Products\Models\Traits;

/**
 * Trait Product.
 */
trait Product
{
    /**
     * Отношение "один к одному" с моделью приза.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->belongsTo(
            app()->make('InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract'),
            'id',
            'product_id'
        );
    }
}
