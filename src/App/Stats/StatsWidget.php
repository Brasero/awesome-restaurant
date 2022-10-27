<?php

namespace App\Stats;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class StatsWidget implements AdminWidgetInterface
{

    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        return "";
    }

    public function menuButtonAdmin(): string
    {
        return $this->renderer->render('@stats/button');
    }

    public function menuButtonClient(): string
    {
        return "";
    }
}
