<?php

namespace App\Taxe;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class TaxeWidget implements AdminWidgetInterface
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        return $this->renderer->render('@taxe/admin/widget');
    }

    public function menuButtonAdmin(): string
    {
        return '';
    }

    public function menuButtonClient(): string
    {
        return '';
    }
}
