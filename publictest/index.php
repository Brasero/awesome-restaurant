<?php

use Framework\App;
use Twig\Environment;
use App\User\UserModule;
use Framework\Renderer\TwigRenderer;
use Twig\Loader\FilesystemLoader;
use function Http\Response\{send};
use GuzzleHttp\Psr7\ServerRequest;

require "../vendor/autoload.php";

$loader = new FilesystemLoader(dirname(__DIR__)."/views");
$twig = new Environment($loader, []);
$renderer = new TwigRenderer($loader, $twig);

$modules = [
    UserModule::class
];

$dependencies = [
    'renderer' => $renderer
];

$app = new App($modules, $dependencies);
$response = $app->run(ServerRequest::fromGlobals());

send($response);