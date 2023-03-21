<?php

use App\Admin\AdminModule;
use App\Cart\CartModule;
use App\Clients\ClientsModule;
use App\Dashboard\DashboardModule;
use Framework\Middleware\AdminAuthMiddleware;
use Framework\Middleware\RedirectAuthMiddleware;
use Framework\Middleware\RouterMiddleware;
use Framework\Middleware\TrailingSlashMiddleware;
use Framework\Middleware\RouterDispatcherMiddleware;
use Framework\Middleware\NotFoundMiddleware;
use App\Ingredient\IngredientModule;
use App\Offre\OffreModule;
use App\Taxe\TaxeModule;
use Framework\App;
use App\User\UserModule;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;
use App\Produit\ProduitModule;
use App\Stats\StatsModule;

require dirname(__DIR__)."/vendor/autoload.php";

$app = new App(dirname(__DIR__) . "/config/config.php");

$app->addModule(AdminModule::class)
    ->addModule(DashboardModule::class)
    ->addModule(OffreModule::class)
    ->addModule(UserModule::class)
    ->addModule(ProduitModule::class)
    ->addModule(IngredientModule::class)
    ->addModule(TaxeModule::class)
    ->addModule(StatsModule::class)
    ->addModule(CartModule::class)
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
