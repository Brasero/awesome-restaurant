<?php


use App\Taxe\Action\TaxeAction;
use App\Taxe\TaxeModule;

return [
    TaxeModule::class => \DI\autowire(),
    TaxeAction::class => \DI\autowire()
];
