<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PHP83Migration' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'method_chaining_indentation' => true,
        'single_quote' => true,
        'no_empty_comment' => true,
        'compact_nullable_type_declaration' => true,
        '@PSR12' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder)
;
