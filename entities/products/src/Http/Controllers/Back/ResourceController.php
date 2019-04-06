<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param DataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     *
     * @throws BindingResolutionException
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return $this->app->make(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param ItemsServiceContract $productsService
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function create(ItemsServiceContract $productsService): FormResponseContract
    {
        $item = $productsService->getItemById();

        return $this->app->make(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param ItemsServiceContract $productsService
     * @param SaveItemRequestContract $request
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function store(ItemsServiceContract $productsService,
                            SaveItemRequestContract $request): SaveResponseContract
    {
        return $this->save($productsService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param ItemsServiceContract $productsService
     * @param int $id
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function edit(ItemsServiceContract $productsService,
                            int $id = 0): FormResponseContract
    {
        $item = $productsService->getItemById($id, [
            'columns' => [
                'ean', 'series', 'group_name', 'shade', 'benefits', 'how_to_use', 'features', 'volume', 'update',
            ],
        ]);

        return $this->app->make(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param ItemsServiceContract $productsService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function update(ItemsServiceContract $productsService,
                            SaveItemRequestContract $request,
                            int $id = 0): SaveResponseContract
    {
        return $this->save($productsService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param ItemsServiceContract $productsService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    protected function save(ItemsServiceContract $productsService,
                            SaveItemRequestContract $request,
                            int $id = 0): SaveResponseContract
    {
        $data = $request->all();

        $item = $productsService->save($data, $id);

        return $this->app->make(SaveResponseContract::class, compact('item'));
    }

    /**
     * Удаление объекта.
     *
     * @param ItemsServiceContract $productsService
     * @param int $id
     *
     * @return DestroyResponseContract
     *
     * @throws BindingResolutionException
     */
    public function destroy(ItemsServiceContract $productsService,
                            int $id = 0): DestroyResponseContract
    {
        $result = $productsService->destroy($id);

        return $this->app->make(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
