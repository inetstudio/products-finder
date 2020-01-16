<?php

namespace InetStudio\ProductsFinder\Products\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:products-finder:products:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup products finder products package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Create folders',
                'command' => 'inetstudio:products-finder:products:folders',
            ],
            [
                'type' => 'artisan',
                'description' => 'Prepare classifiers',
                'command' => 'inetstudio:products-finder:products:classifiers',
            ],
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\ProductsFinder\Products\Providers\ServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
            [
                'type' => 'artisan',
                'description' => 'Publish config',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\ProductsFinder\Products\Providers\ServiceProvider',
                    '--tag' => 'config',
                ],
            ],
        ];
    }
}
