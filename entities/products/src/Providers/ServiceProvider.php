<?php

namespace InetStudio\ProductsFinder\Products\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            'InetStudio\ProductsFinder\Products\Console\Commands\CreateFoldersCommand',
            'InetStudio\ProductsFinder\Products\Console\Commands\PrepareClassifiersCommand',
            'InetStudio\ProductsFinder\Products\Console\Commands\ProcessFeeds',
            'InetStudio\ProductsFinder\Products\Console\Commands\SetupCommand',
        ]);
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/products_finder_products.php' => config_path('products_finder_products.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/filesystems.php', 'filesystems.disks'
        );

        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('products_finder_products')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__.'/../../database/migrations/create_products_finder_products_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_products_finder_products_tables.php'),
        ], 'migrations');
    }

    /**
     * Регистрация путей.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.products-finder.products');
    }
}
