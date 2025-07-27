<?php



use Doctrine\DBAL\Driver\PDO\PgSQL\Driver as PgSQLDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PgSQLDriver::class,
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'postgres',
                    'password' => 'postgres',
                    'dbname'   => 'motoristas_database',
                    'charset'  => 'utf8',
                ],
            ],
        ],
    ],
];
