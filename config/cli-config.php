<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require dirname(__DIR__). '/publictest/index.php';

$container = $app->getContainer();
// replace with mechanism to retrieve EntityManager in your app
$entityManager = $container->get(EntityManagerInterface::class);

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);
