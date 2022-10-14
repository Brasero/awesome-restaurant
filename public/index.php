<?php

use App\Admin\AdminModule;
use App\Dashboard\DashboardModule;
use App\Framework\Middleware\AdminAuthMiddleware;
use App\Framework\Middleware\RedirectAuthMiddleware;
use App\Framework\Middleware\RouterMiddleware;
use App\Framework\Middleware\TrailingSlashMiddleware;
use App\Framework\Middleware\RouterDispatcherMiddleware;
use App\Framework\Middleware\NotFoundMiddleware;
use App\Ingredient\IngredientModule;
use App\Taxe\TaxeModule;
use Framework\App;
use App\User\UserModule;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;
use App\Produit\ProduitModule;

require dirname(__DIR__)."/vendor/autoload.php";

$app = new App(dirname(__DIR__) . "/config/config.php");

$app->addModule(AdminModule::class)
    ->addModule(DashboardModule::class)
    ->addModule(UserModule::class)
    ->addModule(ProduitModule::class)
    ->addModule(IngredientModule::class)
    ->addModule(TaxeModule::class)
    ->linkMiddleware(new TrailingSlashMiddleware())
    ->linkWith(new RouterMiddleware($app->getContainer()))
    ->linkWith(new RedirectAuthMiddleware($app->getContainer()))
    ->linkWith(new AdminAuthMiddleware($app->getContainer()))
    ->linkWith(new RouterDispatcherMiddleware())
    ->linkWith(new NotFoundMiddleware());

if (php_sapi_name() != 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}
