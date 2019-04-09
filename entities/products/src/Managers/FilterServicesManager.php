<?php

namespace InetStudio\ProductsFinder\Products\Managers;

use Illuminate\Support\Manager;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Managers\FilterServicesManagerContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\ModelFilterServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Common\Filter\BuilderFilterServiceContract;

/**
 * Class FilterServicesManager.
 */
class FilterServicesManager extends Manager implements FilterServicesManagerContract
{
    /**
     * FilterServicesManager constructor.
     */
    public function __construct()
    {
        parent::__construct(App::getFacadeApplication());
    }

    /**
     * Возвращаем сервис фильтра.
     *
     * @param  string  $driver
     *
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Возвращаем сервис фильтрации builder.
     *
     * @return BuilderFilterServiceContract
     *
     * @throws BindingResolutionException
     */
    protected function createBuilderDriver(): BuilderFilterServiceContract
    {
        return app()->make(BuilderFilterServiceContract::class);
    }

    /**
     * Возвращаем сервис фильтрации модели.
     *
     * @return ModelFilterServiceContract
     *
     * @throws BindingResolutionException
     */
    protected function createModelDriver(): ModelFilterServiceContract
    {
        return app()->make(ModelFilterServiceContract::class);
    }

    /**
     * Возвращаем имя драйвера по умолчанию.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'model';
    }
}
