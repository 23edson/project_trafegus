<?php

declare(strict_types=1);

namespace Application;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                \Application\View\Helper\BotaoHelper::class => function ($container) {
                    return new \Application\View\Helper\BotaoHelper();
                },
                \Application\View\Helper\BreadcrumbHelper::class => function ($container) {
                    return new \Application\View\Helper\BreadcrumbHelper();
                },
            ],
            'aliases' => [
                'Botao' => \Application\View\Helper\BotaoHelper::class,
                'Breadcrumb' => \Application\View\Helper\BreadcrumbHelper::class,
            ],
        ];
    }
}
