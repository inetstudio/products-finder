<?php

namespace InetStudio\ProductsFinder\Products\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveProductRequestContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ProductsDataTableServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Controllers\Back\ProductsControllerContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ProductsFinder\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ProductsController.
 */
class ProductsController extends Controller implements ProductsControllerContract
{
    /**
     * Список объектов.
     *
     * @param ProductsDataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(ProductsDataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param ProductsServiceContract $productsService
     *
     * @return FormResponseContract
     */
    public function create(ProductsServiceContract $productsService): FormResponseContract
    {
        $item = $productsService->getItemByID();

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param ProductsServiceContract $productsService
     * @param SaveProductRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(ProductsServiceContract $productsService, SaveProductRequestContract $request): SaveResponseContract
    {
        return $this->save($productsService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param ProductsServiceContract $productsService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(ProductsServiceContract $productsService, int $id = 0): FormResponseContract
    {
        $item = $productsService->getItemByID($id, [
            'columns' => ['ean', 'series', 'group_name', 'shade', 'benefits', 'how_to_use', 'features', 'volume', 'update'],
        ]);

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param ProductsServiceContract $productsService
     * @param SaveProductRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(ProductsServiceContract $productsService, SaveProductRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($productsService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param ProductsServiceContract $productsService
     * @param SaveProductRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(ProductsServiceContract $productsService, SaveProductRequestContract $request, int $id = 0): SaveResponseContract
    {
        $data = $request->all();

        $item = $productsService->save($data, $id);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param ProductsServiceContract $productsService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(ProductsServiceContract $productsService, int $id = 0): DestroyResponseContract
    {
        $result = $productsService->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
