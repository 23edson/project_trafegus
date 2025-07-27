<?php 

namespace Veiculo;

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
            Controller\VeiculoController::class => function($container) {
                return new Controller\VeiculoController();
            },
        ],
    ];
}
}

