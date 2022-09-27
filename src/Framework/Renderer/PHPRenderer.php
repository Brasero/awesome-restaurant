<?php

namespace Framework\Renderer;

class PHPRenderer
{


    const DEFAULT_NAMESPACE = "__MAIN";

    /**
     * Liste des chemins disponible pour les vues
     *
     * @var array
     */
    public $paths;


    public function __construct(?string $defaultPath = null)
    {
        if (!is_null($defaultPath))
        {
            $this->addPath($defaultPath);
        }
    }


    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path))
        {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    public function render(string $view): string
    {
        if ($view[0] === "@")
        {
            
        }
        else 
        {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        require($path);
        return ob_get_clean();
    }
}