<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions(array(
    PDO::class => function () {
        $dbPath = dirname(__DIR__) . '/database/database.sqlite';
        return new PDO("sqlite:" . $dbPath);
    },
    League\Plates\Engine::class => function () {
        $path = dirname(__DIR__) . '/resources/views';
        return new League\Plates\Engine($path, 'php');
    }
));

/** @var \Psr\Container\ContainerInterface $container */
$container = $builder->build();

return $container;
