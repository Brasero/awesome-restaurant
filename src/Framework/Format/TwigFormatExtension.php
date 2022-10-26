<?php

namespace Framework\Format;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigFormatExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('ucfirst', [$this, 'ucfirst']),
            new TwigFunction('currencyFormat', [$this, 'numberFormat'])
        ];
    }

    public function ucfirst(string $text): string
    {
        return ucfirst($text);
    }

    public function numberFormat(float $number, string $currency): string
    {
        return number_format($number, 2, ',', '.') . $currency;
    }
}
