<?php
namespace Framework\Router;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\MessageInterface;

trait RedirectTrait
{
    public function redirect(string $name, array $params = []): MessageInterface
    {
        $path = $this->router->generateUrl($name, $params);
        return (new Response())
            ->withHeader('Location', $path);
    }
}
