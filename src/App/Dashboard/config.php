<?php

use App\Dashboard\Action\OffreAction;
use App\Dashboard\DashboardWidget;

return [
    "admin.widgets" => \DI\add([
        \DI\get(DashboardWidget::class)
    ]),
    DashboardWidget::class => \DI\autowire(),
    OffreAction::class => \DI\autowire(),
];
