<?php

use App\Admin\AdminTwigExtension;

return [
    "admin.widgets" => [],
    'admin.prefix' => '/admin',
    AdminTwigExtension::class => \DI\create()->constructor(\DI\get("admin.widgets")),
];
