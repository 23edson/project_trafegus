<?php

namespace Veiculo;

use DoctrineORMModule\Options\EntityManager;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\VeiculoController::class => function ($container) {
                    $entityManager = $container->get(EntityManager::class);
                    return new Controller\VeiculoController($entityManager);
                },
            ],
        ];
    }
}
