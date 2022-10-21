<?php
namespace Framework\Toaster;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ToasterTwigExtension extends AbstractExtension
{

    /**
     * @var Toaster|mixed
     */
    private Toaster $toaster;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->toaster = $container->get(Toaster::class);
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('hasToast', [$this, 'hasToast']),
            new TwigFunction('renderToast', [$this, 'render'], ['is_safe' => ['html']])
        ];
    }

    public function hasToast(): bool
    {
        return $this->toaster->hasToast();
    }

    public function render()
    {
        return $this->toaster->renderToast();
    }
}
