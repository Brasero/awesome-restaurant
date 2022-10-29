<?php

use App\Stats\StatsWidget;

use function DI\autowire;

return [
    StatsWidget::class => autowire(),
    "admin.widgets" => \DI\add([\DI\get(StatsWidget::class)])
];
