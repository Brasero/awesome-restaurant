<?php
namespace Test\Framework;

use App\User\UserModule;
use Framework\App;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;

class AppTest extends TestCase
{

    public function testIndex()
    {
        $app = new App();
        $request = new ServerRequest('GET', '');
        $response = $app->run($request);
        $this->assertEquals('bonjour', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRedirectSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/azeae/');
        $response = $app->run($request);
        $this->assertContains('/azeae', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testWithRouterAndRenderer()
    {
        $app = new App([
            UserModule::class
        ]);
        $request = new ServerRequest('GET', '/connexion');
        $response = $app->run($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}