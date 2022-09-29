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
            new TwigFunction('path', [$this, 'pathFor'])
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->routeur->generateUrl($path, $params);
    }
}
