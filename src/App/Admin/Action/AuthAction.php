<?php

namespace App\Admin\Action;

use App\Framework\Auth\AdminAuth;
use App\Framework\Toaster\Toaster;
use App\Framework\Validator\Validator;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\MessageInterface;

class AuthAction
{
    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;


    /**
     * @var Toaster
     */
    private Toaster $toaster;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $this->container->get(Toaster::class);
        $this->router = $this->container->get(Router::class);
        $this->renderer = $this->container->get(RendererInterface::class);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function authenticate(ServerRequest $request)
    {
        $method = $request->getMethod();
        if ($method === 'POST') {
            $auth = $this->container->get(AdminAuth::class);
            $params = $request->getParsedBody();
            $validator = new Validator($params);
            $errors = $validator->required('username', 'password')
                ->getErrors();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('admin.auth');
            }
            $username = $params['username'] ?? null;
            $password = $params['password'] ?? null;
            if ($auth->login($username, $password)) {
                $this->toaster->createToast('Vous êtes connecté', Toaster::SUCCESS);
                return $this->redirect('admin.home');
            }
            $this->toaster->createToast('Identifiant ou mot de passe inconnu.', Toaster::ERROR);
            return $this->redirect('admin.auth');
        }

        return $this->renderer->render('@admin/connexion');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function authenticateFirst(ServerRequest $request)
    {
        $method = $request->getMethod();
        if ($method === 'POST') {
            $auth = $this->container->get(AdminAuth::class);
            $params = $request->getParsedBody();
            $validator = new Validator($params);
            $errors = $validator
                ->required('username', 'password', 'password_confirm')
                ->strLength('username', 4, 50)
                ->strLength('password', 4, 50)
                ->confirm('password')
                ->getErrors();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('admin.auth.first');
            }
            $username = $params['username'] ?? null;
            $password = $params['password'] ?? null;
            if (!$auth->exist($username)) {
                $this->toaster->createToast('Identifiant inconnu.', Toaster::ERROR);
                return $this->redirect('admin.auth.first');
            }
            if (!$auth->setPassword($username, $password)) {
                $this->toaster->createToast('Votre compte à déjà défini un premier mot de passe.', Toaster::ERROR);
                return $this->redirect('admin.auth.first');
            }
            $this->toaster->createToast('Votre mot de passe à été défini.', Toaster::SUCCESS);
            return $this->redirect('admin.auth');
        }

        return $this->renderer->render('@admin/firstConnexionAdmin');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function logout(): MessageInterface
    {
        $auth = $this->container->get(AdminAuth::class);
        $auth->logout();
        $this->toaster->createToast('Vous êtes déconnecté', Toaster::SUCCESS);
        return $this->redirect('admin.auth');
    }
}
