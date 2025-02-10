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
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'price-offer-api',
        // 'route' => 'api/price-offer',
        'pluralize' => false,
    ],

];