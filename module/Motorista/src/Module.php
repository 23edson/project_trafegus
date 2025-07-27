<?php

namespace Motorista;

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
                Controller\MotoristaController::class => function ($container) {
                    return new Controller\MotoristaController();
                },
            ],
        ];
    }
}
