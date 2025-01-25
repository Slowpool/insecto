<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
    'username' => 'root', 
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

// php yii migrate/create create_goods_unit_table
