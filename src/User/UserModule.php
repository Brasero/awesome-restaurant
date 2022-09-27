<?php
namespace App\User;

use Framework\Router\Router;

class UserModule
{

    public function __construct(Router $router)
    {
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
        return 'User connexion';
    }

    public function inscription()
    {
        return 'User inscription';
    }

    public function espace()
    {
        return 'User espace';
    }
}