<?php


use App\Taxe\Action\TaxeAction;
use App\Taxe\TaxeModule;
use App\Taxe\TaxeWidget;

return [
    TaxeModule::class => \DI\autowire(),
    TaxeAction::class => \DI\autowire(),
    "admin.widgets" => \DI\add([
        \DI\get(TaxeWidget::class)
    ]),
    TaxeWidget::class => \DI\autowire()

];


