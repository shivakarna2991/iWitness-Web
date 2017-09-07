<?php
$_SERVER['REQUEST_METHOD'] = "GET";
$_SERVER['SERVER_PROTOCOL']= 'HTTP/1.0';

include '../public/wp-config.php';

$doctrine = array(
    'name' => 'Doctrine Migrations',
    'migrations_namespace' => 'DoctrineMigrations',
    'table' => 'doctrine_migration_versions',
    'migrations_directory' => './migrations',
    'db_configuration' => array(
        'host' => DB_HOST,
        'dbname' => DB_NAME,
        'user' => DB_USER,
        'password' => DB_PASSWORD,
        'driver' => 'pdo_mysql',
    )
);
return $doctrine;


