<?php

use Framework\Renderer\TwigRendererFactory;
use Framework\Renderer\RendererInterface;
use Framework\Routeur\Router;

return [
    "config.view_path" => dirname(__DIR__) . '\views',
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    Router::class => \DI\create()
];