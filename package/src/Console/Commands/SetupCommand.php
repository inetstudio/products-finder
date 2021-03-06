<?php

namespace InetStudio\ProductsFinder\Console\Commands;

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
    protected $name = 'inetstudio:products-finder:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup products finder package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Products finder products setup',
                'command' => 'inetstudio:products-finder:products:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Products finder links setup',
                'command' => 'inetstudio:products-finder:links:setup',
            ],
        ];
    }
}
