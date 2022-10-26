<?php

use Framework\Format\TwigFormatExtension;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use Framework\Toaster\ToasterTwigExtension;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Database\DatabaseFactory;
use Framework\Renderer\TwigRendererFactory;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Framework\Router\RouteurTwigExtension;

return [
    "config.view_path" => dirname(__DIR__) . '\views',
    "doctrine.is_dev_mode" => true,
    "doctrine.proxy_dir" => null,
    "doctrine.cache" => null,
    "doctrine.use_simple_annotation_reader" => true,
    "database.host" => "localhost",
    "database.user" => "root",
    "database.pass" => "",
    "database.dbname" => "test_doctrine",
    "database.port" => "3306",
    "database.charset" => "utf8",
    "twig.extensions" => [
        RouteurTwigExtension::class,
        TwigFormatExtension::class,
        ToasterTwigExtension::class,
    ],
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    Router::class => \DI\create(),
    EntityManagerInterface::class => \DI\factory(DatabaseFactory::class),
    SessionInterface::class => \DI\get(PHPSession::class),
];
