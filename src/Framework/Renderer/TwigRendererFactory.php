<?php
namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Psr\Container\ContainerInterface;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $viewPath = $container->get('config.view_path');
        $loader = new FilesystemLoader($viewPath);
        $twig = new Environment($loader, []);
        $extensions = $container->get("twig.extensions");
        foreach ($extensions as $extension) {
            $twig->addExtension($container->get($extension));
        }
        return new TwigRenderer($loader, $twig);
    }
}
