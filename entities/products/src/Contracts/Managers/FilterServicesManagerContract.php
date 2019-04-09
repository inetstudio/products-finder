<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Managers;

/**
 * Interface FilterServicesManagerContract.
 */
interface FilterServicesManagerContract
{
    /**
     * Возвращаем сервис фильтра.
     *
     * @param  string  $driver
     *
     * @return mixed
     */
    public function with($driver);
}
