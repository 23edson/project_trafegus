<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class BotaoHelper extends AbstractHelper
{
    public function __invoke(
        string $label,
        string $url = '#',
        string $class = 'btn btn-primary',
        string $icon = '',
        bool $submit = false
    ): string {
        $iconHtml = $icon ? "<i class=\"{$icon}\"></i> " : '';

        // se precisar utilizar em um form
        if ($submit) {
            return "<button type=\"submit\" class=\"{$class}\">{$iconHtml}{$label}</button>";
        }

        return "<a href=\"{$url}\" class=\"{$class}\">{$iconHtml}{$label}</a>";
    }
}
