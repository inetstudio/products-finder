<?php

return [
    /*
     * Настройки изображений
     */

    'feeds' => [

    ],

    'images' => [
        'quality' => 100,
        'conversions' => [
            'product' => [
                'preview' => [
                    'default' => [
                        [
                            'name' => 'preview_default',
                            'size' => [
                                'width' => 200,
                                'height' => 300,
                            ],
                        ],
                        [
                            'name' => 'preview_admin',
                            'size' => [
                                'width' => 128,
                                'height' => 128,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
