<?php


use App\User\UserWidget;
use function DI\get;
use App\User\UserModule;
use function DI\autowire;
use Framework\TwigExtension\MenuTwigExtension;

return [
    "user.prefix" => "/user",
    "admin.widgets" => \DI\add([
        \DI\get(UserWidget::class)
    ]),

    UserModule::class => autowire()->constructorParameter('prefix', get('user.prefix')),
    MenuTwigExtension::class => \DI\autowire()->constructorParameter('widgets', \DI\get('admin.widgets')),
    UserWidget::class => \DI\autowire(),

];