<?php

// use yii\db\mssql\PDO;

// $dsn = "mysql:host=127.0.0.1;port=3307;dbname=insecto";
// $user = "root";
// $pass = "gg";

// try {
//     $pdo = new PDO($dsn, $user, $pass);
//     echo "Connected successfully";
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }

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