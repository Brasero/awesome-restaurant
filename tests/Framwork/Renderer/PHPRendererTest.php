<?php
namespace Test\Framework\Renderer;

use Framework\Renderer\PHPRenderer;
use PHPUnit\Framework\TestCase;

class PHPRendererTest extends TestCase
{
    public function testAddPath()
    {
        $renderer = new PHPRenderer();
        $renderer->addPath('@user', __DIR__ . "/views");
        $this->assertContains(__DIR__ . "/views", $renderer->paths);
        $this->assertEquals(__DIR__ . "/views", $renderer->paths['@user']);
    }

    public function testDefaultAddPath()
    {
        $renderer = new PHPRenderer(dirname(__DIR__) . "/views");
        $this->assertEquals(dirname(__DIR__) . '/views', $renderer->paths[$renderer::DEFAULT_NAMESPACE]);
    }

    public function testRender()
    {
        $renderer = new PHPRenderer();
        $renderer->addPath('@test', __DIR__ . '/views');
        $render = $renderer->render('@test/index');
        $this->assertEquals('<h1>Hello</h1>', $render);
    }
}