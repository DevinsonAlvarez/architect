<?php

$finder = PhpCsFixer\Finder::create()
    ->in([(__DIR__) . '/src', (__DIR__) . '/tests']);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_strict_types' => true,
    'void_return' => true,
    'simplified_null_return' => true,
    'no_unused_imports' => true,
])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
