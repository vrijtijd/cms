<?php

$finder = PhpCsFixer\Finder::create()
    ->in('app')
    ->in('bootstrap')
    ->in('config')
    ->in('database')
    ->in('routes')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'yoda_style' => false,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
