<?php

use App\Offre\Action\OffreAction;
use App\Offre\OffreModule;

return [
    OffreModule::class => \DI\autowire(),
    OffreAction::class => \DI\autowire(),
];
