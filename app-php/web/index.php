<?php

use Dotenv\Dotenv;

require '/app/config/consts.php';

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// TODO remove if it is useless in the end. and don't forget to remove this dependency
// $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
// $dotenv->load();

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
