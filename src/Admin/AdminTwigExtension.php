<?php
namespace App\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AdminTwigExtension extends AbstractExtension
{

    /**
     * @var array
     */
    private array $widgets;

    public function __construct(array $widgets)
    {
        $this->widgets = $widgets;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('admin_menu', [$this, 'adminMenu'], ['is_safe' => ['html']])
        ];
    }

    public function adminWidget(): string
    {
        return array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->render();
        }, '');
    }

    public function adminMenu(): string
    {
        return array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->menuButtonAdmin();
        }, '');
    }
}
