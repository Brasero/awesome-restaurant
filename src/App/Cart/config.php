<?php

use App\Cart\CartModule;
use App\Cart\CartWidget;
use function DI\add;
use function DI\autowire;
use function DI\get;

return [
    CartWidget::class => autowire(),
    CartModule::class => autowire(),
    "admin.widgets" => add([get(CartWidget::class)]),
];
