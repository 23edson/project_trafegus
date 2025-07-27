<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\PsrCachedReader;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\ORM\Configuration;

require_once __DIR__ . '/../vendor/autoload.php';
// Caminhos onde estão suas entidades
$paths = [
    __DIR__ . '/../module/Motorista/src/Entity',
    __DIR__ . '/../module/Veiculo/src/Entity'
];

// Modo de desenvolvimento
$isDevMode = true;

// Configuração do banco de dados
$dbParams = [
    'driver'   => 'pgsql',
    'host'     => 'localhost',
    'dbname'   => 'motoristas_database',
    'user'     => 'postgres',
    'password' => 'postgres',
];


$config = new Configuration();
$cache = new ArrayAdapter();
$reader = new AnnotationReader();
$cachedReader = new PsrCachedReader($reader, $cache);

$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($cachedReader, $paths);
$config->setMetadataDriverImpl($driver);

$config->setProxyDir(__DIR__ . '/../Proxies');
$config->setProxyNamespace('Proxies');
$config->setAutoGenerateProxyClasses(true);

return EntityManager::create($dbParams, $config);
