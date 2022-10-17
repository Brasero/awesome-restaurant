<?php

namespace App\Ingredient;

use App\Admin\AdminWidgetInterface;
use Framework\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;

class IngredientWidget implements AdminWidgetInterface
{

    /**
     * @var RendererInterface $renderer
     */
    private RendererInterface $renderer;

    public function __construct(ContainerInterface $container)
    {
        $this->renderer = $container->get(RendererInterface::class);
    }

    public function render(): string
    {
        return '';
    }


    public function menuButtonAdmin(): string
    {
        return $this->renderer->render('@ingredient/admin/button');
    }

    public function menuButtonClient(): string
    {
        return "";
    }
}
