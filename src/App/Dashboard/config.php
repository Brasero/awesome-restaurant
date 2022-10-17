<?php

use App\Dashboard\DashboardWidget;
use App\Offre\Action\OffreAction;

return [
    "admin.widgets" => \DI\add([
        \DI\get(DashboardWidget::class)
    ]),
    DashboardWidget::class => \DI\autowire(),
];
