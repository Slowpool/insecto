<?php

// `php yii migrate` entrypoint is not a index.php file, so require consts again.
// TODO i'm not sure 
// require_once __DIR__ . '/consts.php';
// upd: YAGNI moment?

$host = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbPassword = $_ENV['DB_PASSWORD'];

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$host;port=3306;dbname=$dbName",
    'username' => 'root',
    'password' => $dbPassword,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];