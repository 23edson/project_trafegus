<?php



use Veiculo\Controller\VeiculoController;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'veiculos' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/veiculos[/:action[/:id]]',
                    'defaults' => [
                        'controller' => 'Veiculo\Controller\Veiculo',
                        'action' => 'index',
                    ],
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                ],
                'may_terminate' => true,
            ],
            'veiculos-listar-json' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/veiculos/listar-json',
                    'defaults' => [
                        'controller' => 'Veiculo\Controller\Veiculo',
                        'action' => 'listarJson',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'aliases' => [
            'Veiculo\Controller\Veiculo' => VeiculoController::class,
        ],
        'factories' => [
            \Veiculo\Controller\VeiculoController::class => function ($container) {
                return new \Veiculo\Controller\VeiculoController(
                    $container->get('doctrine.entitymanager.orm_default')
                );
            },
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'doctrine' => [
        'driver' => [
            'application_entities' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'Veiculo_entitities' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],

            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities',
                    'Veiculo\Entity' => 'Veiculo_entitities',
                ],
            ],
        ],
    ],
];
