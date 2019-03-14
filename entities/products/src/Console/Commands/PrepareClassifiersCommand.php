<?php

namespace InetStudio\ProductsFinder\Products\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class PrepareClassifiersCommand.
 */
class PrepareClassifiersCommand extends Command
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:products-finder:products:classifiers';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Create package classifiers';

    /**
     * Запуск команды.
     *
     * @return void
     */
    public function handle(): void
    {
        $classifiersGroupsService = app()->make('InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract');

        $groups = [
            'Область' => 'scopes_of_use',
            'Тип' => 'types',
            'Цвет' => 'colors',
            'Страна' => 'countries',
            'Возраст' => 'age',
            'Пол' => 'sex',
            'Тип кожи' => 'skin_types',
            'Текстура' => 'textures',
            'SPF' => 'spf',
            'Применение для лица' => 'face_applications',
            'Применение для волос' => 'hair_applications',
        ];

        foreach ($groups as $name => $alias) {
            $classifiersGroupsService->model::updateOrCreate([
                'name' => 'Products Finder / '.$name,
            ], [
                'alias' => 'products_finder_'.$alias,
            ]);
        }
    }
}
