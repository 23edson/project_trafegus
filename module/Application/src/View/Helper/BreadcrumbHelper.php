<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class BreadcrumbHelper extends AbstractHelper
{
    public function __invoke(array $items)
    {
        $html = '<nav aria-label="breadcrumb">';
        $html .= '<ol class="breadcrumb bg-light p-2 rounded">';

        foreach ($items as $item) {
            if (isset($item['active']) && $item['active']) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">'
                    . htmlspecialchars($item['label']) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item">'
                    . '<a href="' . htmlspecialchars($item['href']) . '" class="text-decoration-none">'
                    . htmlspecialchars($item['label']) . '</a></li>';
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}
