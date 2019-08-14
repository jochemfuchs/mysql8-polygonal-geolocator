<?php

$finder = PhpCsFixer\Finder
    ::create()
    ->exclude([
        'vendor',
        'storage',
        'resources/views',
        'bootstrap/cache'
    ])
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config
    ::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'                              => true,
        '@Symfony'                           => true,
        'binary_operator_spaces'             => ['default' => 'align'],
        'strict_param'                       => true,
        'array_syntax'                       => ['syntax' => 'short'],
        'linebreak_after_opening_tag'        => true,
        'single_blank_line_before_namespace' => true,
        'not_operator_with_successor_space'  => true,
        'trailing_comma_in_multiline_array'  => true,
        'ordered_imports'                    => [
            'sortAlgorithm' => 'length',
        ],
        'ordered_class_elements'             => true,
        'phpdoc_order'                       => true,
        'no_unused_imports'                  => true,
        'yoda_style'                         => true,
    ])
    ->setFinder($finder);