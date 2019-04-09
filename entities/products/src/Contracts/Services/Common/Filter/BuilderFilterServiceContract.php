<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface BuilderFilterServiceContract.
 */
interface BuilderFilterServiceContract
{
    /**
     * Применяем фильтры.
     *
     * @param  Builder  $builder
     * @param  array  $filters
     *
     * @return Builder
     */
    public static function apply(Builder $builder, array $filters = []): Builder;
}
