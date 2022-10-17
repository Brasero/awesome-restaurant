<?php

use App\Ingredient\IngredientWidget;

return [
    "admin.widgets" => \DI\add([
        \DI\get(IngredientWidget::class)
    ]),
    IngredientWidget::class => \DI\autowire()
];
