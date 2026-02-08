#!/usr/bin/env php
<?php
/**
 * Command-line interface for Arabic to DIN 31635 Converter
 * 
 * Usage:
 *   php convert.php "السلام عليكم"
 *   php convert.php -f input.txt
 *   php convert.php -f input.txt -o output.txt
 *   echo "مرحبا" | php convert.php
 */

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

use ArabicDIN31635\ArabicDIN31635Converter;

// Parse command-line arguments
$options = getopt('f:o:hv', ['file:', 'output:', 'help', 'version']);

// Show help
if (isset($options['h']) || isset($options['help'])) {
    showHelp();
    exit(0);
}

// Show version
if (isset($options['v']) || isset($options['version'])) {
    $converter = new ArabicDIN31635Converter();
    echo "Arabic to DIN 31635 Converter v" . $converter->getVersion() . "\n";
    exit(0);
}

// Get input text
$inputText = '';

if (isset($options['f']) || isset($options['file'])) {
    $filename = $options['f'] ?? $options['file'];
    if (!file_exists($filename)) {
        fwrite(STDERR, "Error: File not found: $filename\n");
        exit(1);
    }
    $inputText = file_get_contents($filename);
} elseif ($argc > 1 && !str_starts_with($argv[1], '-')) {
    $inputText = $argv[1];
} elseif (function_exists('posix_isatty') && !posix_isatty(STDIN)) {
    // Read from stdin
    $inputText = stream_get_contents(STDIN);
} elseif (stream_isatty(STDIN) === false) {
    // Fallback for systems without posix
    $inputText = stream_get_contents(STDIN);
} else {
    showHelp();
    exit(1);
}

// Convert text
$converter = new ArabicDIN31635Converter();
$output = $converter->convert($inputText);

// Write output
if (isset($options['o']) || isset($options['output'])) {
    $outputFile = $options['o'] ?? $options['output'];
    if (file_put_contents($outputFile, $output) === false) {
        fwrite(STDERR, "Error: Could not write to file: $outputFile\n");
        exit(1);
    }
    echo "Conversion complete. Output saved to: $outputFile\n";
} else {
    echo $output;
    if (!str_ends_with($output, "\n")) {
        echo "\n";
    }
}

exit(0);

/**
 * Display help information
 */
function showHelp(): void
{
    echo <<<HELP
Arabic to DIN 31635 Converter - Command Line Tool

Usage:
  php convert.php [OPTIONS] [TEXT]
  php convert.php "Arabic text here"
  echo "Arabic text" | php convert.php

Options:
  -f, --file FILE      Read input from FILE
  -o, --output FILE    Write output to FILE (default: stdout)
  -h, --help          Show this help message
  -v, --version       Show version information

Examples:
  php convert.php "السلام عليكم"
  php convert.php -f input.txt
  php convert.php -f input.txt -o output.txt
  echo "مرحبا" | php convert.php

HELP;
}
