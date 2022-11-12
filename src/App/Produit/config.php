<?php

use App\Produit\Action\ProduitAction;
use App\Produit\ProduitWidget;

return [
    "categorie.img.basePath" => "./assets/img/ressources/categorie/",
    "produit.img.basePath" => "./assets/img/ressources/produit/",
    "admin.widgets" => \DI\add([\DI\get(ProduitWidget::class)]),
    ProduitWidget::class => \DI\autowire(),
    ProduitAction::class => \DI\autowire(),
];
