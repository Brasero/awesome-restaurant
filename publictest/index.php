<?php

use Framework\App;
use function Http\Response\{send};
use App\User\UserModule;
use GuzzleHttp\Psr7\ServerRequest;

require "../vendor/autoload.php";

$modules = [
    UserModule::class
];

$app = new App($modules);
$response = $app->run(ServerRequest::fromGlobals());

send($response);