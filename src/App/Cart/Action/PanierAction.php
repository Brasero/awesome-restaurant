<?php

namespace App\Cart\Action;

use App\Entity\Panier;
use App\Entity\PanierLigne;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Auth\UserAuth;
use Framework\Cart\Cart;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Framework\Session\SessionInterface;
use Framework\Toaster\Toaster;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PanierAction
{

    use RedirectTrait;

    private $repository;
    private Router $router;
    private EntityManagerInterface $manager;
    private Toaster $toaster;
    private ContainerInterface $container;
    private SessionInterface $session;
    private RendererInterface $renderer;
    private UserAuth $userAuth;
    private Cart $panier;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->router = $container->get(Router::class);
        $this->repository = $this->manager->getRepository(Produit::class);
        $this->session = $container->get(SessionInterface::class);
        $this->renderer = $container->get(RendererInterface::class);
        $this->userAuth = $container->get(UserAuth::class);
        $this->panier = $container->get(Cart::class);
    }

    public function index(RequestInterface $request): string
    {
        $panier = $this->session->get('panier');
        $total = 0;
        if ($panier) {
            foreach ($panier as $ligne) {
                $total += $ligne->getProduit()->getPrix() * $ligne->getQuantite();
            }
        } else {
            $panier = [];
        }
        return $this->renderer->render(
            '@panier/panier',
            compact('panier', 'total')
        );
    }


    public function add(RequestInterface $request)
    {
        $product = $this->retrieveProduct($request);

        if ($this->userAuth->isLogged()) {
        } else {
            return $this->panier->addSession($product);
        }
    }

    public function decrease(RequestInterface $request)
    {

        $product = $this->retrieveProduct($request);

        if ($this->userAuth->isLogged()) {
        } else {
            return $this->panier->decreaseSession($product);
        }
    }

    public function increase(RequestInterface $request)
    {

        $product = $this->retrieveProduct($request);

        if ($this->userAuth->isLogged()) {
        } else {
            return $this->panier->increaseSession($product);
        }
    }

    public function remove(RequestInterface $request)
    {
        $product = $this->retrieveProduct($request);

        if ($this->userAuth->isLogged()) {
        } else {
            return $this->panier->removeSession($product);
        }
    }

    private function retrieveProduct(RequestInterface $request)
    {
        $id = $request->getAttribute('id', null);
        $product = $this->repository->find($id);

        if ($product === null) {
            $this->toaster->createToast('Produit introuvable', Toaster::ERROR);
            return $this->redirect('carte.index');
        }

        return $product;
    }
}
