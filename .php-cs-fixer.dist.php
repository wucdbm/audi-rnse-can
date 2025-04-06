<?php declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$date = date('Y');
$headerComment = <<<COMMENT
Copyright (C) 2025-{$date} Martin Kirilov

Developed and maintained at https://github.com/wucdbm/audi-rnse-can

Use as you like, as a library or as a direct solution

Inspiration and documentation for the CAN codes mainly found at
https://github.com/peetereczek/openauto-audi-api
https://www.janssuuh.nl/en/skin-audi-rns-full-beta/
COMMENT;

$finder = Finder::create()->in([
    __DIR__ . '/src',
]);

// https://cs.symfony.com/

$config = (new Config());
$config->setRules([
    '@Symfony' => true,
    'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline',
    ],
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'trailing_comma_in_multiline' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'cast_spaces' => [
        'space' => 'none',
    ],
    'function_declaration' => [
        'closure_function_spacing' => 'one',
    ],
    'phpdoc_align' => [
        'align' => 'left',
    ],
    'single_line_throw' => false,
    'header_comment' => [
        'comment_type' => 'comment',
        'header' => $headerComment,
        'separate' => 'bottom',
    ],
    'linebreak_after_opening_tag' => false,
    'blank_line_after_opening_tag' => false,
//    'declare_strict_types' => true,
])
    ->setUsingCache(true)
    ->setFinder($finder);


return $config;
