<?php

namespace Framework\TwigExtension;

use Exception;

class AssetsTwigExtension extends \Twig\Extension\AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('asset', [$this, 'asset'])
        ];
    }

    /**
     * @throws Exception
     */
    public function asset(string $path, ?string $name = null): string
    {
        $file = dirname(__DIR__, 3) . '/public' . $path;
        if (!is_null($name)) {
            $file .= '/' . $name;
            $path .= '/' . $name;
        }
        if (!file_exists($file)) {
            throw new Exception('File "' . $file . '" not found');
        }
        $path .= '?' . filemtime($file);
        return $path;
    }
}
