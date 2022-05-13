<?php

return
[
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' => 'db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'mariadb',
            'name' => $_ENV['MARIADB_DATABASE'],
            'user' => $_ENV['MARIADB_USER'],
            'pass' => $_ENV['MARIADB_PASSWORD'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
    ],

    'version_order' => 'creation'
];
