<?php

use function DI\get;
use App\User\UserModule;
use App\User\UserWidget;
use function DI\autowire;
use Framework\TwigExtension\MenuTwigExtension;

return [
    "user.prefix" => "/user",
    "admin.widgets" => \DI\add([
        \DI\get(UserWidget::class)
    ]),
    "user.widgets" => \DI\add([
        \DI\get(\App\User\CommandeWidget::class),
        \DI\get(\App\User\AdresseWidget::class),
        \DI\get(\App\User\ParamProfilWidget::class),
        \DI\get(\App\User\AideWidget::class),

    ]),
    UserModule::class => autowire()->constructorParameter('prefix', get('user.prefix')),
    MenuTwigExtension::class => \DI\autowire()->constructorParameter('widgets', \DI\get('admin.widgets')),
    UserWidget::class => \DI\autowire(),

];