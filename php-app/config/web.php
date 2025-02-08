<?php

use AutoMapperPlus\AutoMapper;

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
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qYFNDaiaxDLPp1yQBti8eUrkrr8JGX45',
            'parsers' => [
                // TODO do app need it?
                'application/json' => 'yii\web\JsonParser',
            ],
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
            'enableStrictParsing' => true,
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
}

return $config;
