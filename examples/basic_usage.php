<?php
/**
 * Basic usage example for Arabic DIN31635 Converter
 */

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

use ArabicDIN31635\ArabicDIN31635Converter;

// Create converter instance
$converter = new ArabicDIN31635Converter();

// Example 1: Convert a single word
echo "Example 1: Single Word\n";
echo "Arabic: مرحبا\n";
echo "DIN 31635: " . $converter->convert('مرحبا') . "\n\n";

// Example 2: Convert a phrase
echo "Example 2: Common Phrase\n";
echo "Arabic: السلام عليكم\n";
echo "DIN 31635: " . $converter->convert('السلام عليكم') . "\n\n";

// Example 3: Convert text with numbers
echo "Example 3: With Numbers\n";
echo "Arabic: سنة ٢٠٢٤\n";
echo "DIN 31635: " . $converter->convert('سنة ٢٠٢٤') . "\n\n";

// Example 4: Convert religious text
echo "Example 4: Religious Text\n";
echo "Arabic: بسم الله الرحمن الرحيم\n";
echo "DIN 31635: " . $converter->convert('بسم الله الرحمن الرحيم') . "\n\n";

// Example 5: Convert names
echo "Example 5: Names\n";
$names = ['محمد', 'فاطمة', 'علي', 'عائشة'];
foreach ($names as $name) {
    echo "Arabic: $name => DIN 31635: " . $converter->convert($name) . "\n";
}
echo "\n";

// Example 6: Geographic names
echo "Example 6: Geographic Names\n";
$places = ['القاهرة', 'دمشق', 'بغداد', 'الرياض'];
foreach ($places as $place) {
    echo "Arabic: $place => DIN 31635: " . $converter->convert($place) . "\n";
}
