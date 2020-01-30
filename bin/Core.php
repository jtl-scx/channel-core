<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/23/20
 */

use JTL\SCX\Lib\Channel\Core\AbstractApplicationContext;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

putenv('APP_ENV=dev');

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

$isDevelopment = true;
$rootDir = realpath(__DIR__ . '/..');
$containerCachePath = realpath(__DIR__ . '/../var/cache') . '/container';
$listenerCachePath = realpath(__DIR__ . '/../var/cache') . '/listener';

$core = new class($isDevelopment, $rootDir, $containerCachePath, $listenerCachePath) extends AbstractApplicationContext {
    public function __construct($isDevelopment, $rootDir, $containerCachePath, $listenerCachePath)
    {
        parent::__construct($isDevelopment, $rootDir, $containerCachePath, $listenerCachePath);
    }
};

$core->bootstrap();
$container = $core->getContainer();

$application = new Application('core-dev-cli');
$commandLoader = $container->get('console.command_loader');

$application->setCommandLoader($commandLoader);
$application->run();
