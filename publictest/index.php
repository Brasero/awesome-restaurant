<?php

use App\Admin\AdminModule;
use App\Ingredient\IngredientModule;
use Framework\App;
use App\User\UserModule;
use DI\ContainerBuilder;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;
use \App\Produit\ProduitModule;

require dirname(__DIR__)."/vendor/autoload.php";

$modules = [
    AdminModule::class,
    UserModule::class,
    ProduitModule::class,
    IngredientModule::class
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . "/config/config.php");

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}

$container = $builder->build();

$app = new App($container, $modules);

if (php_sapi_name() != 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}
