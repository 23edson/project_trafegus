<?php




use Laminas\Router\Http\Segment;
use Rastreamento\Controller\RastreamentoController;

return [
    'router' => [
        'routes' => [
            'rastreamento' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/rastreamento[/:action[/:id]]',
                    'defaults' => [
                        'controller' => 'Rastreamento\Controller\Rastreamento',
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
            'Rastreamento\Controller\Rastreamento' => RastreamentoController::class,
        ],
        'factories' => [
            \Rastreamento\Controller\RastreamentoController::class => function ($container) {
                return new \Rastreamento\Controller\RastreamentoController(
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

            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities',

                ],
            ],
        ],
    ],
];
