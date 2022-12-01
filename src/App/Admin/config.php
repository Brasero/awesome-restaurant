<?php

use App\Admin\AdminTwigExtension;

return [
    "admin.widgets" => [],
    "user.widgets" => [],
    'admin.prefix' => '/admin',
    AdminTwigExtension::class => \DI\create()->constructor(\DI\get("admin.widgets")),
    AdminTwigExtension::class => \DI\create()->constructor(\DI\get("user.widgets")),
];
