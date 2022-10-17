<?php

use App\Produit\ProduitWidget;

return [
    "categorie.img.basePath" => "./assets/img/ressources/categorie/",
    "admin.widgets" => \DI\add([\DI\get(ProduitWidget::class)]),
    ProduitWidget::class => \DI\autowire()
];
