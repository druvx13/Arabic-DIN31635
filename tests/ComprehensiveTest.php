<?php
/**
 * Comprehensive PHPUnit Tests for Arabic to DIN 31635 Converter
 * 
 * Meticulous test suite covering ALL Arabic characters and edge cases
 */

use PHPUnit\Framework\TestCase;
use ArabicDIN31635\ArabicDIN31635Converter;

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

class ComprehensiveArabicDIN31635Test extends TestCase
{
    private ArabicDIN31635Converter $converter;
    
    protected function setUp(): void
    {
        $this->converter = new ArabicDIN31635Converter();
    }
    
    /**
     * Test ALL basic Arabic consonants (28 letters)
     */
    public function testAllBasicConsonants(): void
    {
        $testCases = [
            // Hamza and Alif variations
            'ء' => 'ʾ',   // hamza
            'آ' => 'ʾā',  // alif with madda
            'أ' => 'ʾa',  // hamza on alif
            'ؤ' => 'ʾu',  // hamza on waw
            'إ' => 'ʾi',  // hamza under alif
            'ئ' => 'ʾ',   // hamza on ya
            'ا' => 'ā',   // alif
            
            // All 28 Arabic letters
            'ب' => 'b',   // ba
            'ت' => 't',   // ta
            'ث' => 'ṯ',   // tha
            'ج' => 'ǧ',   // jim
            'ح' => 'ḥ',   // ha
            'خ' => 'ḫ',   // kha
            'د' => 'd',   // dal
            'ذ' => 'ḏ',   // dhal
            'ر' => 'r',   // ra
            'ز' => 'z',   // zay
            'س' => 's',   // sin
            'ش' => 'š',   // shin
            'ص' => 'ṣ',   // sad
            'ض' => 'ḍ',   // dad
            'ط' => 'ṭ',   // ta (emphatic)
            'ظ' => 'ẓ',   // za (emphatic)
            'ع' => 'ʿ',   // ayn
            'غ' => 'ġ',   // ghayn
            'ف' => 'f',   // fa
            'ق' => 'q',   // qaf
            'ك' => 'k',   // kaf
            'ل' => 'l',   // lam
            'م' => 'm',   // mim
            'ن' => 'n',   // nun
            'ه' => 'h',   // ha
            'و' => 'w',   // waw
            'ي' => 'y',   // ya
            'ى' => 'á',   // alif maqsura
            'ة' => 'ẗ',   // ta marbuta
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals(
                $expected, 
                $result, 
                sprintf("Failed: '%s' (U+%04X) should convert to '%s' but got '%s'", 
                    $arabic, 
                    mb_ord($arabic), 
                    $expected, 
                    $result
                )
            );
        }
    }
    
    /**
     * Test ALL Arabic diacritical marks
     */
    public function testAllDiacritics(): void
    {
        $testCases = [
            'َ' => 'a',   // fatha
            'ُ' => 'u',   // damma
            'ِ' => 'i',   // kasra
            'ً' => 'an',  // fathatan (tanween fath)
            'ٌ' => 'un',  // dammatan (tanween damm)
            'ٍ' => 'in',  // kasratan (tanween kasr)
            'ْ' => '',    // sukun
            'ّ' => '',    // shadda (tested separately)
            'ٓ' => '',    // maddah above
            'ٔ' => 'ʾ',   // hamza above
            'ٕ' => 'ʾ',   // hamza below
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals(
                $expected, 
                $result,
                sprintf("Diacritic U+%04X failed", mb_ord($arabic))
            );
        }
    }
    
    /**
     * Test shadda (gemination) with ALL consonants
     */
    public function testShaddaWithAllConsonants(): void
    {
        $consonants = [
            'ب' => 'b', 'ت' => 't', 'ث' => 'ṯ', 'ج' => 'ǧ',
            'ح' => 'ḥ', 'خ' => 'ḫ', 'د' => 'd', 'ذ' => 'ḏ',
            'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'š',
            'ص' => 'ṣ', 'ض' => 'ḍ', 'ط' => 'ṭ', 'ظ' => 'ẓ',
            'ع' => 'ʿ', 'غ' => 'ġ', 'ف' => 'f', 'ق' => 'q',
            'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'ه' => 'h', 'و' => 'w', 'ي' => 'y',
        ];
        
        foreach ($consonants as $arabic => $latin) {
            $withShadda = $arabic . 'ّ';
            $expected = $latin . $latin;
            $result = $this->converter->convert($withShadda);
            $this->assertEquals(
                $expected, 
                $result,
                sprintf("Shadda test failed for '%s'", $arabic)
            );
        }
    }
    
    /**
     * Test ALL Arabic-Indic numerals
     */
    public function testAllArabicIndicNumerals(): void
    {
        $testCases = [
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
        
        // Test full number sequence
        $fullNumber = '٠١٢٣٤٥٦٧٨٩';
        $this->assertEquals('0123456789', $this->converter->convert($fullNumber));
        
        // Test mixed numbers
        $mixedNumber = '٢٠٢٤';
        $this->assertEquals('2024', $this->converter->convert($mixedNumber));
    }
    
    /**
     * Test ALL Arabic punctuation marks
     */
    public function testAllPunctuation(): void
    {
        $testCases = [
            '،' => ',',  // Arabic comma
            '؛' => ';',  // Arabic semicolon
            '؟' => '?',  // Arabic question mark
            '٪' => '%',  // Arabic percent sign
            '٫' => '.',  // Arabic decimal separator
            '٬' => ',',  // Arabic thousands separator
            '٭' => '*',  // Arabic five pointed star
            '«' => '«',  // Left guillemet
            '»' => '»',  // Right guillemet
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    /**
     * Test definite article with ALL moon letters
     */
    public function testDefiniteArticleAllMoonLetters(): void
    {
        $moonLetters = ['ا', 'ب', 'ج', 'ح', 'خ', 'ع', 'غ', 'ف', 'ق', 'ك', 'م', 'ه', 'و', 'ي'];
        
        foreach ($moonLetters as $letter) {
            $word = 'ال' . $letter;
            $result = $this->converter->convert($word);
            $this->assertStringStartsWith('al-', $result,
                "Moon letter test failed for: ال$letter"
            );
        }
    }
    
    /**
     * Test definite article with ALL sun letters
     */
    public function testDefiniteArticleAllSunLetters(): void
    {
        $sunLetters = ['ت', 'ث', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ل', 'ن'];
        
        foreach ($sunLetters as $letter) {
            $word = 'ال' . $letter;
            $result = $this->converter->convert($word);
            $this->assertStringStartsWith('a', $result);
            $this->assertStringContainsString('-', $result,
                "Sun letter test failed for: ال$letter"
            );
            // Verify assimilation occurred - the sun letter should be doubled
            $map = $this->converter->getTransliterationMap();
            $transliterated = $map[$letter] ?? $letter;
            $this->assertStringContainsString($transliterated . $transliterated, $result,
                "Sun letter should be doubled for: ال$letter"
            );
        }
    }
    
    /**
     * Test complete words with diacritics
     */
    public function testCompleteWordsWithDiacritics(): void
    {
        $testCases = [
            // Words with full diacritics
            'كِتَابٌ' => 'kitābun',      // a book (nominative)
            'كِتَابًا' => 'kitāban',     // a book (accusative)
            'كِتَابٍ' => 'kitābin',      // a book (genitive)
            'مَدْرَسَةٌ' => 'madrasaẗun', // a school
            'قَلَمٌ' => 'qalamun',       // a pen
            'بَيْتٌ' => 'baytun',        // a house
            'مُحَمَّدٌ' => 'muḥammadun',  // Muhammad (with shadda)
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result,
                "Failed to convert diacritized word: $arabic"
            );
        }
    }
    
    /**
     * Test common Arabic phrases
     */
    public function testCommonArabicPhrases(): void
    {
        $testCases = [
            'السلام عليكم' => 'ass-lām ʿlykm',
            'و عليكم السلام' => 'w ʿlykm ass-lām',
            'بسم الله الرحمن الرحيم' => 'bsm all-h arr-ḥmn arr-ḥym',
            'الحمد لله' => 'al-ḥmd llh',
            'ما شاء الله' => 'mā šāʾ all-h',
            'إن شاء الله' => 'ʾin šāʾ all-h',
            'جزاك الله خيرا' => 'ǧzāk all-h ḫyrā',
            'بارك الله فيك' => 'bārk all-h fyk',
            'أهلا و سهلا' => 'ʾahlā w shlā',
            'مرحبا' => 'mrḥbā',
            'شكرا' => 'škrā',
            'عفوا' => 'ʿfwā',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result,
                "Failed to convert phrase: $arabic"
            );
        }
    }
    
    /**
     * Test Quranic text samples
     */
    public function testQuranicTextSamples(): void
    {
        $testCases = [
            'القرآن' => 'al-qrʾān',
            'الفاتحة' => 'al-fātḥẗ',
            'البقرة' => 'al-bqrẗ',
            'آل عمران' => 'ʾāl ʿmrān',
            'النساء' => 'ann-sāʾ',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result,
                "Failed to convert Quranic reference: $arabic"
            );
        }
    }
    
    /**
     * Test names transliteration
     */
    public function testArabicNames(): void
    {
        $testCases = [
            'محمد' => 'mḥmd',
            'أحمد' => 'ʾaḥmd',
            'علي' => 'ʿly',
            'فاطمة' => 'fāṭmẗ',
            'عائشة' => 'ʿāʾšẗ',
            'خديجة' => 'ḫdyǧẗ',
            'عبد الله' => 'ʿbd all-h',
            'عبد الرحمن' => 'ʿbd arr-ḥmn',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result,
                "Failed to convert name: $arabic"
            );
        }
    }
    
    /**
     * Test geographic names
     */
    public function testGeographicNames(): void
    {
        $testCases = [
            'مصر' => 'mṣr',
            'السعودية' => 'ass-sʿwdyẗ',
            'الإمارات' => 'al-ʾimārāt',
            'الكويت' => 'al-kwyt',
            'البحرين' => 'al-bḥryn',
            'العراق' => 'al-ʿrāq',
            'الشام' => 'ašš-ām',
            'المغرب' => 'al-mġrb',
            'القاهرة' => 'al-qāhrẗ',
            'دمشق' => 'dmšq',
            'بغداد' => 'bġdād',
            'الرياض' => 'arr-yāḍ',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result,
                "Failed to convert geographic name: $arabic"
            );
        }
    }
    
    /**
     * Test edge cases
     */
    public function testEdgeCases(): void
    {
        // Empty string
        $this->assertEquals('', $this->converter->convert(''));
        
        // Single character
        $this->assertEquals('ā', $this->converter->convert('ا'));
        
        // Only diacritics
        $this->assertEquals('a', $this->converter->convert('َ'));
        
        // Only spaces
        $this->assertEquals('   ', $this->converter->convert('   '));
        
        // Newlines and tabs
        $this->assertEquals("\n\t", $this->converter->convert("\n\t"));
        
        // Mixed Arabic and English
        $result = $this->converter->convert('Hello مرحبا World');
        $this->assertStringContainsString('Hello', $result);
        $this->assertStringContainsString('mrḥbā', $result);
        $this->assertStringContainsString('World', $result);
        
        // Numbers mixed with Arabic
        $result = $this->converter->convert('سنة ٢٠٢٤');
        $this->assertStringContainsString('snẗ', $result);
        $this->assertStringContainsString('2024', $result);
    }
    
    /**
     * Test tatweel (kashida) removal
     */
    public function testTatweelRemoval(): void
    {
        // Tatweel should be removed
        $this->assertEquals('allāh', $this->converter->convert('اللـــه'));
        $this->assertEquals('mḥmd', $this->converter->convert('محـــمـــد'));
    }
    
    /**
     * Test long text passages
     */
    public function testLongTextPassage(): void
    {
        $arabicText = 'في البداية كان الكلام، و الكلام كان عند الله، و كان الكلام الله.';
        $result = $this->converter->convert($arabicText);
        
        // Verify result is not empty
        $this->assertNotEmpty($result);
        
        // Verify some key conversions
        $this->assertStringContainsString('fy', $result);
        $this->assertStringContainsString('al-bdāyẗ', $result);
        $this->assertStringContainsString('all-h', $result);
    }
    
    /**
     * Test that the converter is idempotent for Latin text
     */
    public function testIdempotentForLatinText(): void
    {
        $latinText = 'This is English text with numbers 12345';
        $result = $this->converter->convert($latinText);
        
        // Latin text should pass through unchanged
        $this->assertStringContainsString('This is English', $result);
        $this->assertStringContainsString('12345', $result);
    }
    
    /**
     * Test multiple consecutive spaces
     */
    public function testMultipleSpaces(): void
    {
        $text = 'مرحبا    بكم';
        $result = $this->converter->convert($text);
        $this->assertStringContainsString('    ', $result);
    }
    
    /**
     * Test combined diacritics
     */
    public function testCombinedDiacritics(): void
    {
        // Shadda with fatha
        $this->assertEquals('mma', $this->converter->convert('مَّ'));
        
        // Shadda with kasra
        $this->assertEquals('mmi', $this->converter->convert('مِّ'));
        
        // Shadda with damma  
        $this->assertEquals('mmu', $this->converter->convert('مُّ'));
    }
    
    /**
     * Test that getVersion returns valid version
     */
    public function testGetVersion(): void
    {
        $version = $this->converter->getVersion();
        $this->assertNotEmpty($version);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', $version);
    }
    
    /**
     * Test that getTransliterationMap returns complete map
     */
    public function testGetTransliterationMap(): void
    {
        $map = $this->converter->getTransliterationMap();
        
        $this->assertIsArray($map);
        $this->assertNotEmpty($map);
        
        // Check for essential characters
        $essentialChars = ['ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س'];
        foreach ($essentialChars as $char) {
            $this->assertArrayHasKey($char, $map,
                "Missing essential character: $char"
            );
        }
    }
    
    /**
     * Test convertWord method
     */
    public function testConvertWordMethod(): void
    {
        $this->assertEquals('ktāb', $this->converter->convertWord('كتاب'));
        $this->assertEquals('mrḥbā', $this->converter->convertWord('مرحبا'));
    }
    
    /**
     * Test convertText method
     */
    public function testConvertTextMethod(): void
    {
        $this->assertEquals('as-slām ʿlykm', $this->converter->convertText('السلام عليكم'));
        $this->assertEquals('mrḥbā bkm', $this->converter->convertText('مرحبا بكم'));
    }
}
