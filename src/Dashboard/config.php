<?php

use App\Dashboard\DashboardWidget;

return [
    "admin.widgets" => \DI\add([
        \DI\get(DashboardWidget::class)
    ]),
    DashboardWidget::class => \DI\autowire()
];
