<?php
namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    /**
     * Twig environment
     *
     * @var Environment
     */
    private $twig;

    /**
     * Twig configuration
     *
     * @var FilesystemLoader
     */
    private $loader;

    public function __construct(FilesystemLoader $loader, Environment $environment)
    {
        $this->loader = $loader;
        $this->twig = $environment;
    }

    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }

    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.html.twig', $params);
    }

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
