<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Inclua o autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Aqui você deve instanciar seu EntityManager
$entityManager = require_once __DIR__ . '/../config/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
