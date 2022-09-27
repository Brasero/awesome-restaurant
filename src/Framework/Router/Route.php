<?php
namespace Framework\Router;

/**
 * Représente une route matché
 */
class Route
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string|callable
     */
    private $callback;

    /**
     *
     * @var string[]
     */
    private $params;

    /**
     *
     * @param string $name nom de la route
     * @param string|callable $callback function | method à appeler
     * @param array $params tableau de paramètres
     */
    public function __construct(string $name, $callback, array $params)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }

    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @return string|callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}