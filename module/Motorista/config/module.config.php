<?php



use Motorista\Controller\MotoristaController;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'motoristas' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/motoristas[/:action[/:id]]',
                    'defaults' => [
                        'controller' => 'Motorista\Controller\Motorista',
                        'action' => 'index',
                    ],
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],

    'controllers' => [
        'aliases' => [
            'Motorista\Controller\Motorista' => MotoristaController::class,
        ],
        'factories' => [
            \Motorista\Controller\MotoristaController::class => function ($container) {
                return new \Motorista\Controller\MotoristaController(
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
            'motorista_entities' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],

            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities',
                    'Motorista\Entity' => 'motorista_entities',

                ],
            ],
        ],
    ],
];
