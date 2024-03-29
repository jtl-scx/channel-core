<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create();
$finder->in(['src', 'tests']);


$config = new PhpCsFixer\Config();
$config->setFinder($finder);
$config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
]);

return $config;