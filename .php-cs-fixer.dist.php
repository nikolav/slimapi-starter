<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/public')
    ->in(__DIR__ . '/database')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// --------------------------------------------------------
// FORCE 2-SPACE INDENTATION
// --------------------------------------------------------
// PHP-CS-Fixer supports this by configuring the whitespace settings:
//     indent = "  "  (two spaces)
//     lineEnding = "\n"
// --------------------------------------------------------

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setUsingCache(true)
    ->setIndent('  ')     // <-- 2 spaces
    ->setLineEnding("\n")
    ->setRules([
        // Base standard
        '@PSR12' => true,

        // Use short arrays: []
        'array_syntax' => ['syntax' => 'short'],

        // Imports
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,

        // Namespace formatting
        // 'single_blank_line_before_namespace' => true,
        'blank_line_after_namespace' => true,

        // Whitespace rules
        'no_extra_blank_lines' => [
            'tokens' => ['extra', 'use', 'return'],
        ],
        'no_trailing_whitespace' => true,
        'indentation_type' => true,

        // Comments / PHPDoc
        'phpdoc_indent' => true,
        'phpdoc_trim' => true,
        'phpdoc_no_empty_return' => true,

        // Control structures
        'no_superfluous_elseif' => true,
        'no_unneeded_control_parentheses' => true,

        // Strings
        'single_quote' => true,

        // Misc
        'no_closing_tag' => true,
    ])
    ->setFinder($finder);
