<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальный диск для хранения медиа постов
     */

    'products_finder_products' => [
        'driver' => 'local',
        'root' => storage_path('app/public/products_finder/products'),
        'url' => env('APP_URL').'/storage/products_finder/products',
        'visibility' => 'public',
    ],
];
