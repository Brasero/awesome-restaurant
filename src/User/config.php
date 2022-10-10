<?php

use App\User\UserModule;
use function DI\autowire;
use function DI\get;

return [
    "user.prefix" => "/user",
    UserModule::class => autowire()->constructorParameter('prefix', get('user.prefix'))
];
