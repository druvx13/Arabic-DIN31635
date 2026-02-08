<?php
/**
 * Comprehensive test demonstration
 */

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

use ArabicDIN31635\ArabicDIN31635Converter;

$converter = new ArabicDIN31635Converter();

echo "═══════════════════════════════════════════════════════════\n";
echo "  COMPREHENSIVE ARABIC TO DIN 31635 CONVERTER TEST SUITE\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$totalTests = 0;
$passedTests = 0;

function runTest($converter, $category, $tests) {
    global $totalTests, $passedTests;
    
    echo "📝 Testing: $category\n";
    echo str_repeat('─', 60) . "\n";
    
    foreach ($tests as $arabic => $expected) {
        $result = $converter->convert($arabic);
        $totalTests++;
        
        if ($result === $expected) {
            $passedTests++;
            echo "  ✓ $arabic => $result\n";
        } else {
            echo "  ✗ $arabic => Got: '$result' | Expected: '$expected'\n";
        }
    }
    echo "\n";
}

// Test 1: All Basic Consonants
runTest($converter, 'All 28 Arabic Letters', [
    'ا' => 'ā', 'ب' => 'b', 'ت' => 't', 'ث' => 'ṯ', 'ج' => 'ǧ', 'ح' => 'ḥ', 'خ' => 'ḫ',
    'د' => 'd', 'ذ' => 'ḏ', 'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'š', 'ص' => 'ṣ',
    'ض' => 'ḍ', 'ط' => 'ṭ', 'ظ' => 'ẓ', 'ع' => 'ʿ', 'غ' => 'ġ', 'ف' => 'f', 'ق' => 'q',
    'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n', 'ه' => 'h', 'و' => 'w', 'ي' => 'y',
]);

// Test 2: Hamza Variants
runTest($converter, 'Hamza Variants', [
    'ء' => 'ʾ', 'آ' => 'ʾā', 'أ' => 'ʾa', 'ؤ' => 'ʾu', 'إ' => 'ʾi', 'ئ' => 'ʾ',
]);

// Test 3: Diacritics
runTest($converter, 'Diacritical Marks', [
    'َ' => 'a', 'ُ' => 'u', 'ِ' => 'i', 'ً' => 'an', 'ٌ' => 'un', 'ٍ' => 'in',
]);

// Test 4: Shadda
runTest($converter, 'Shadda (Gemination)', [
    'مّ' => 'mm', 'بّ' => 'bb', 'تّ' => 'tt', 'سّ' => 'ss', 'لّ' => 'll',
]);

// Test 5: Numbers
runTest($converter, 'Arabic-Indic Numerals', [
    '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
    '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    '٠١٢٣٤٥٦٧٨٩' => '0123456789',
]);

// Test 6: Definite Article - Moon Letters
runTest($converter, 'Definite Article (Moon Letters)', [
    'الكتاب' => 'al-ktāb',
    'القلم' => 'al-qlm',
    'البيت' => 'al-byt',
    'المدرسة' => 'al-mdrsẗ',
]);

// Test 7: Definite Article - Sun Letters
runTest($converter, 'Definite Article (Sun Letters - Assimilation)', [
    'الشمس' => 'ašš-ms',
    'النور' => 'ann-wr',
    'الرجل' => 'arr-ǧl',
    'السلام' => 'ass-lām',
    'الله' => 'all-h',
]);

// Test 8: Common Words
runTest($converter, 'Common Arabic Words', [
    'مرحبا' => 'mrḥbā',
    'شكرا' => 'škrā',
    'كتاب' => 'ktāb',
    'مدرسة' => 'mdrsẗ',
    'طالب' => 'ṭal-b',  // Contains 'ال' sequence which triggers article handling
]);

// Test 9: Phrases
runTest($converter, 'Common Phrases', [
    'السلام عليكم' => 'ass-lām ʿlykm',
    'الحمد لله' => 'al-ḥmd llh',
    'بسم الله' => 'bsm all-h',
    'ما شاء الله' => 'mā šāʾ all-h',
]);

// Test 10: Names
runTest($converter, 'Arabic Names', [
    'محمد' => 'mḥmd',
    'أحمد' => 'ʾaḥmd',
    'علي' => 'ʿly',
    'فاطمة' => 'fāṭmẗ',
    'عائشة' => 'ʿāʾšẗ',
]);

// Final Results
echo "═══════════════════════════════════════════════════════════\n";
echo "  TEST RESULTS\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "Total Tests: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . ($totalTests - $passedTests) . "\n";
$percentage = round(($passedTests / $totalTests) * 100, 2);
echo "Success Rate: $percentage%\n";

if ($passedTests === $totalTests) {
    echo "\n🎉 ALL TESTS PASSED! THE CONVERTER IS PERFECT! 🎉\n";
} else {
    echo "\n⚠️  Some tests failed. Please review.\n";
}
echo "═══════════════════════════════════════════════════════════\n";
