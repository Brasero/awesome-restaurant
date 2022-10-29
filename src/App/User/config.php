<?php

use Framework\TwigExtension\MenuTwigExtension;
use App\User\UserModule;
use App\User\UserWidget;
use function DI\autowire;
use function DI\get;

return [
    "user.prefix" => "/user",
    "admin.widgets" => \DI\add([
        \DI\get(UserWidget::class)
    ]),
    UserModule::class => autowire()->constructorParameter('prefix', get('user.prefix')),
    MenuTwigExtension::class => \DI\autowire()->constructorParameter('widgets', \DI\get('admin.widgets')),
    UserWidget::class => \DI\autowire(),

];
