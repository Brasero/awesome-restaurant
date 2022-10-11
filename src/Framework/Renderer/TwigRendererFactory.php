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
        $extensions = $container->get("twig.extensions");
        foreach ($extensions as $extension) {
            $twig->addExtension($container->get($extension));
        }
        return new TwigRenderer($loader, $twig);
    }
}
