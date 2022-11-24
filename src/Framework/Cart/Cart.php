<?php

namespace Framework\Cart;

use App\Entity\PanierLigne;
use App\Entity\Produit;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Framework\Session\SessionInterface;
use Framework\Toaster\Toaster;
use Psr\Container\ContainerInterface;

class Cart
{

    use RedirectTrait;

    private SessionInterface $session;
    private Toaster $toaster;
    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $this->session = $container->get(SessionInterface::class);
        $this->toaster = $container->get(Toaster::class);
        $this->router = $container->get(Router::class);
    }
    
    public function addSession(Produit $product)
    {
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

        $this->toaster->createToast('Produit ajouté au panier', Toaster::SUCCESS);
        return $this->redirect('carte.index');
    }

    public function decreaseSession(Produit $product)
    {
        $panier = $this->session->get("panier", []);
        foreach ($panier as $ligne) {
            if ($ligne->getProduit()->getId() === $product->getId()) {
                if ($ligne->getQuantite() > 1) {
                    $ligne->setQuantite($ligne->getQuantite() - 1);
                    $this->session->set("panier", $panier);
                    return $this->redirect('panier.index');
                }
            }
        }
        $this->removeSession($product);
        return $this->redirect('panier.index');
    }

    public function increaseSession(Produit $product)
    {
        $panier = $this->session->get("panier", []);
        foreach ($panier as $ligne) {
            if ($ligne->getProduit()->getId() === $product->getId()) {
                $ligne->setQuantite($ligne->getQuantite() + 1);
                $this->session->set("panier", $panier);
                return $this->redirect('panier.index');
            }
        }
        $this->toaster->createToast('Erreur : Identifiant inconnu.', Toaster::ERROR);
        return $this->redirect('panier.index');
    }

    public function removeSession(Produit $product)
    {
        $panier = $this->session->get("panier", []);
        foreach ($panier as $key => $ligne) {
            if ($ligne->getProduit()->getId() === $product->getId()) {
                unset($panier[$key]);
                $this->session->set("panier", $panier);
                $this->toaster->createToast('Produit supprimé du panier', Toaster::SUCCESS);
                return $this->redirect('panier.index');
            }
        }
        $this->toaster->createToast('Produit non trouvé', Toaster::ERROR);
        return $this->redirect('panier.index');
    }
}
