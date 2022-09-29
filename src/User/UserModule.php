<?php
namespace App\User;

use Framework\Module;
use Framework\Router\Router;
use Framework\Renderer\RendererInterface;

class UserModule extends Module
{


    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     *
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('user', __DIR__ . "/views");
        $this->renderer = $renderer;
        $router->get($prefix . '/connexion', [$this, 'connexion'], 'user.connexion');
        $router->get($prefix . '/inscription', [$this, 'inscription'], 'user.inscription');
        $router->get($prefix . '/espace', [$this, 'espace'], 'user.espace');
    }


    public function __invoke(): string
    {
        return $this->connexion();
    }

    public function connexion(): string
    {
        return $this->renderer->render('@user/connexion');
    }

    public function inscription(): string
    {
        return $this->renderer->render('@user/inscription');
    }

    public function espace(): string
    {
        return $this->renderer->render('@user/espace');
    }
}
