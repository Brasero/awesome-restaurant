<?php

namespace App\Cart\Action;

use App\Entity\Panier;
use App\Entity\PanierLigne;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->router = $container->get(Router::class);
        $this->repository = $this->manager->getRepository(Produit::class);
        $this->session = $container->get(SessionInterface::class);
        $this->renderer = $container->get(RendererInterface::class);
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
        $id = $request->getAttribute('id', null);
        $product = $this->repository->find($id);

        if ($product === null) {
            $this->toaster->createToast('Produit introuvable', Toaster::ERROR);
            return $this->redirect('carte.index');
        }

        if ($this->session->has("auth")) {
        } else {
            $panier = $this->session->get("panier", []);
            foreach ($panier as $ligne) {
                if ($ligne->getProduit()->getId() === $product->getId()) {
                    $ligne->setQuantite($ligne->getQuantite() + 1);
                    $this->session->set("panier", $panier);
                    $this->toaster->createToast('Produit ajouté au panier', Toaster::SUCCESS);
                    return $this->redirect('carte.index');
                }
            }
            $panierLigne = new PanierLigne();
            $panierLigne->setProduit($product)
                ->setQuantite(1);
            $panier[] = $panierLigne;
            $this->session->set("panier", $panier);
        }

        $this->toaster->createToast('Produit ajouté au panier', Toaster::SUCCESS);
        return $this->redirect('carte.index');
    }
}
