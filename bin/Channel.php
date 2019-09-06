<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/06
 */

require_once __DIR__ . '/../vendor/autoload.php';


$containerCreator = new \JTL\SCX\Channel\DependencyInjection\ContainerCreator(true);

$container = $containerCreator->createInstance(
    __DIR__ . '/../src',
    __DIR__ . '/../config/service1.yml',
    __DIR__ . '/../config/service2.yml',
    __DIR__ . '/../cache.php'
);


$application = $container->get(\Symfony\Component\Console\Application::class);

$application->run();