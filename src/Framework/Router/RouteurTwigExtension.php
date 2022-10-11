<?php
namespace Framework\Router;

use Twig\TwigFunction;
use Framework\Router\Router;

class RouteurTwigExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * Routeur
     *
     * @var Router
     */
    private $routeur;

    public function __construct(Router $routeur)
    {
        $this->routeur = $routeur;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('path', [$this, 'pathFor']),
            new TwigFunction('is_active', [$this, 'isActive'])
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->routeur->generateUrl($path, $params);
    }

    public function isActive(string $path): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $expectedUri = $this->routeur->generateUrl($path);
        return str_contains($expectedUri, $uri);
    }
}
