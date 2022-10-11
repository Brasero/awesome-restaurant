<?php

namespace App\Produit;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;

class ProduitWidget implements AdminWidgetInterface
{

    /**
     * @var RendererInterface
     */
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
        return $this->renderer->render('@produit/admin/button');
    }

    public function menuButtonClient(): string
    {
        return $this->renderer->render('@produit/button');
    }
}
