<?php
namespace Test\Framework;

use App\User\UserModule;
use Framework\App;
use Framework\Router\Router;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;

class RouterTest extends TestCase
{
    /**
     *
     * @var Routeur
     */
    private $router;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGet()
    {
        $request = new ServerRequest('GET', '/user');
        $this->router->get('/user', function () {
            return 'user';
        }, 'user');
        $route = $this->router->match($request);
        $this->assertEquals('user', $route->getName());
        $this->assertEquals('user', call_user_func_array($route->getCallback(), [$request]));
    }
    
    public function testAutoAddUserGetRoute()
    {
        $routes = [
            "/connexion",
            "/inscription",
            "/espace"
        ];
        $app = new App([
            UserModule::class
        ]);

        foreach($routes as $path)
        {
            $name = 'user.';
            $name .= substr($path, 1);
            $request = new ServerRequest('GET', $path);
            
            $route = $app->router->match($request);
            $this->assertEquals($name, $route->getName());
        }
    }


}