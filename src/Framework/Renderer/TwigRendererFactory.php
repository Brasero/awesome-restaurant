<?php
namespace Framework\Renderer;

use App\Framework\Format\TwigFormatExtension;
use App\Framework\Toaster\ToasterTwigExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Framework\Router\RouteurTwigExtension;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $viewPath = $container->get('config.view_path');
        $loader = new FilesystemLoader($viewPath);
        $twig = new Environment($loader, []);
        $twig->addExtension($container->get(RouteurTwigExtension::class));
        $twig->addExtension($container->get(TwigFormatExtension::class));
        $twig->addExtension($container->get(ToasterTwigExtension::class));
        return new TwigRenderer($loader, $twig);
    }
}
