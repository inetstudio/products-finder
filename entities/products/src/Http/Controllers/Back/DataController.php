<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  string  $service
     *
     * @return JsonResponse
     *
     * @throws BindingResolutionException
     */
    public function getData(string $service): JsonResponse
    {
        $dataTableService = $this->getService($service);

        return $dataTableService->ajax();
    }

    /**
     * Получаем html таблицы.
     *
     * @param  Request  $request
     * @param  string  $service
     *
     * @return string
     *
     * @throws BindingResolutionException
     */
    public function getHtml(Request $request, string $service): string
    {
        $dataTableService = $this->getService($service);

        $default = [
            'class' => 'table table-striped table-bordered table-hover dataTable',
        ];

        $options = array_merge($default, $request->all());

        return $dataTableService->html()->table($options);
    }

    /**
     * Получаем настройки datatables.
     *
     * @param  string  $service
     *
     * @return string
     *
     * @throws BindingResolutionException
     */
    public function getOptions(string $service): string
    {
        $dataTableService = $this->getService($service);

        return $dataTableService->html()->generateJson();
    }

    /**
     * @param  string  $serviceName
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    protected function getService(string $serviceName)
    {
        $serviceContract = 'InetStudio\\ProductsFinder\\Products\\Contracts\\Services\\Back\\DataTables\\'.Str::studly($serviceName).'ServiceContract';

        return $this->app->make($serviceContract);
    }
}
