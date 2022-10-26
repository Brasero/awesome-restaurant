<?php

namespace Framework\TwigExtension;

use App\Admin\AdminWidgetInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuTwigExtension extends AbstractExtension
{

    /**
     * @var array
     */
    private array $widgets;

    public function __construct(array $widgets)
    {
        $this->widgets = $widgets;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nav_link', [$this, 'navLink'], ["is_safe" => ['html']]),
        ];
    }

    public function navLink(): string
    {
        return array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->menuButtonClient();
        }, '');
    }
}
