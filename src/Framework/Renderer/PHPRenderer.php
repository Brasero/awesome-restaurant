<?php

namespace Framework\Renderer;

class PHPRenderer implements RendererInterface
{


    const DEFAULT_NAMESPACE = "__MAIN";

    /**
     * Liste des chemins disponible pour les vues
     *
     * @var array
     */
    private $paths = [];

    /**
     * Ensemble de variable disponible globallement
     *
     * @var array
     */
    private $globals = [];

    /**
     *
     * @param string|null $defaultPath Chemin des vues par defaut
     */
    public function __construct(?string $defaultPath = null)
    {
        if (!is_null($defaultPath))
        {
            $this->addPath($defaultPath);
        }
    }


    /**
     * Ajoute des variable globales a toute les vues
     *
     * @param string $key 
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * Ajoute le chemin d'un ensemble de vue sous un namespace si préciser
     *
     * @param string $namespace Namespace ou path si le path n'est pas passé
     * @param string|null $path Chemin vers le dossier de vue
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path))
        {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    /**
     * Affiche la vue souhaitez en y injectant les eventuelles données passez dans params
     *
     * @param string $view Nom de la vue ex : @blog/index
     * @param array $params liste des paramètre a injécter dans la vue.
     * @return string 
     */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view))
        {
            $path = $this->replaceNamespace($view) . ".php";
        }
        else 
        {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] === "@";
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        $str = str_replace('@' . $namespace, $this->paths[$namespace], $view);
        return str_replace('/', '\\', $str);
    }
}