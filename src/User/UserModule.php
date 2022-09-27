<?php
namespace App\User;

use Framework\Router\Router;
use Framework\Renderer\PHPRenderer;

class UserModule
{

    /**
     *
     * @var PHPRenderer
     */
    private $renderer; 

    public function __construct(Router $router, PHPRenderer $renderer)
    {
        $renderer->addPath('user', __DIR__ . "/views");
        $this->renderer = $renderer;
        $router->get('/connexion', [$this, 'connexion'], 'user.connexion');
        $router->get('/inscription', [$this, 'inscription'], 'user.inscription');
        $router->get('/espace', [$this, 'espace'], 'user.espace');
    }


    public function __invoke()
    {
        return $this->connexion();
    }

    public function connexion()
    {
        return $this->renderer->render('@user/connexion');
    }

    public function inscription()
    {
        return $this->renderer->render('@user/inscription');
    }

    public function espace()
    {
        return $this->renderer->render('@user/espace');
    }
}