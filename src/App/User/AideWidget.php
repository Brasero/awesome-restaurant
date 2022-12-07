<?php

namespace App\User;

use Framework\Renderer\RendererInterface;

class AideWidget implements UserWidgetInterface
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }


    public function menuButtonUser(): string
    {
        return $this->renderer->render('@user/AideButton');
    }
}