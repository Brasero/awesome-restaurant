<?php

namespace App\User;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class UserWidget implements AdminWidgetInterface
{

    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        return $this->renderer->render('@user/admin/widget');
    }

    public function menuButtonAdmin(): string
    {
        return $this->renderer->render('@user/admin/button');
    }

    public function menuButtonClient(): string
    {
        return $this->renderer->render('@user/button');
    }
}
