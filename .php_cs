<?php

return PhpCsFixer\Config::create()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->files()
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
            ->append([__FILE__])
    )
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'no_empty_phpdoc' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_test_annotation' => true,
        'phpdoc_trim' => true,
    ]);
