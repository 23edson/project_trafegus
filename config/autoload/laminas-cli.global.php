<?php

return [
    'laminas-cli' => [
        'commands' => [
            'mvc:crud' => \Divix\Laminas\Cli\Command\CrudCommand::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Divix\Laminas\Cli\Command\CrudCommand::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];
