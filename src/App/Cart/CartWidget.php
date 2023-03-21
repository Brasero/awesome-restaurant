<?php

namespace App\Cart;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class CartWidget implements AdminWidgetInterface
{

    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        return '';
    }

    public function menuButtonAdmin(): string
    {
        return '';
    }

    public function menuButtonClient(): string
    {
        return $this->renderer->render('@carte/button');
    }
}
