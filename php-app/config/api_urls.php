<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'category-api',
        // TODO it can be done via $patterns
        // 'route' => 'api/category',
        'pluralize' => false,
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'goods-item-api',
        // 'route' => 'api/goods-item',
        'pluralize' => false,
        'extraPatterns' => [
            'PATCH goods-reception' => 'goods-reception',
            'POST register-as-died' => 'register-as-died',
            'POST set-main-picture' => 'set-main-picture',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'price-offer-api',
        'except' => [
            // delete the old one and create a new one instead of updating
            'update',
            // is divided into 'create-via-price' and 'create-via-discount-percentage'
            'create'
        ],
        // 'route' => 'api/price-offer',
        'pluralize' => false,
        'extraPatterns' => [
            'POST create-via-price' => 'create-via-price',
            'POST create-via-discount-percentage' => 'create-via-discount-percentage',
            'POST create-for-category' => 'create-for-category',
        ],
    ],

];