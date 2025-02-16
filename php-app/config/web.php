<?php

use AutoMapperPlus\AutoMapper;
use yii\helpers\Json;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$autoMapperConfig = require __DIR__ . '/automapper.php';

$config = [
    'id' => 'basic',
    'name' => 'Insecto',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => require 'aliases.php',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'qYFNDaiaxDLPp1yQBti8eUrkrr8JGX45',
            // 'parsers' => [
            //     // TODO do app need it?
            //     'application/json' => function($rawBody) {
            //         return Json::decode($rawBody);
            //     },
            // ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'home/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/views/contacts',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // order matters here
                ...require 'api_urls.php',
                ...require 'web_urls.php',
            ],
        ],
        'automapper' => [
            'class' => AutoMapper::class,
            '__construct()' => [$autoMapperConfig],
        ],
    ],
    'params' => $params,
    'modules' => [
        'swagger' => [
            'class' => \Yiisoft\Swagger\Action\SwaggerUi::class,
            // 'apiInfo' => [
            //     'title' => 'My API',
            //     'version' => '1.0.0',
            // ],
            // 'excludes' => [],
            // 'scanner' => [
            //     'paths' => [__DIR__ . '/../../src'], // Adjust the path to your controllers
            //     'commentProcessors' => [],
            // ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['172.19.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['172.19.0.1'],
    ];
    
    // $config['bootstrap'][] = 'swagger';
    // $config['modules']['swagger'] = [
    //     'class' => \Yiisoft\Swagger\Service\SwaggerService::class,
    //     // 'allowedIPs' => ['172.19.0.1'],
    //     // 'apiInfo' => [
    //     //     // 'title' => 'My API',
    //     //     // 'version' => '1.0.0',
    //     // ],
    //     // 'excludes' => [],
    //     // 'scanner' => [
    //     //     'paths' => [Yii::getAlias('@app/controllers/API')],
    //     //     // 'commentProcessors' => [],
    //     // ],
    // ];
}

return $config;
