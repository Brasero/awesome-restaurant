<?php

use App\User\UserModule;
use function DI\{autowire, get};

return [
    "user.prefix" => "/user",
    UserModule::class => autowire()->constructorParameter('prefix', get('user.prefix'))
];