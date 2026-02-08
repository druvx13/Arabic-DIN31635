<?php
/**
 * PHPUnit Tests for Arabic to DIN 31635 Converter
 * 
 * Comprehensive test suite for the converter class
 */

use PHPUnit\Framework\TestCase;
use ArabicDIN31635\ArabicDIN31635Converter;

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

class ArabicDIN31635ConverterTest extends TestCase
{
    private ArabicDIN31635Converter $converter;
    
    protected function setUp(): void
    {
        $this->converter = new ArabicDIN31635Converter();
    }
    
    public function testBasicConsonants(): void
    {
        $testCases = [
            'ب' => 'b',
            'ت' => 't',
            'ث' => 'ṯ',
            'ج' => 'ǧ',
            'ح' => 'ḥ',
            'خ' => 'ḫ',
            'د' => 'd',
            'ذ' => 'ḏ',
            'ر' => 'r',
            'ز' => 'z',
            'س' => 's',
            'ش' => 'š',
            'ص' => 'ṣ',
            'ض' => 'ḍ',
            'ط' => 'ṭ',
            'ظ' => 'ẓ',
            'ع' => 'ʿ',
            'غ' => 'ġ',
            'ف' => 'f',
            'ق' => 'q',
            'ك' => 'k',
            'ل' => 'l',
            'م' => 'm',
            'ن' => 'n',
            'ه' => 'h',
            'و' => 'w',
            'ي' => 'y',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result, "Failed to convert: $arabic");
        }
    }
    
    public function testVowelsAndDiacritics(): void
    {
        $testCases = [
            'َ' => 'a',   // fatha
            'ُ' => 'u',   // damma
            'ِ' => 'i',   // kasra
            'ً' => 'an',  // fathatan
            'ٌ' => 'un',  // dammatan
            'ٍ' => 'in',  // kasratan
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testHamzaVariants(): void
    {
        $testCases = [
            'ء' => 'ʾ',
            'أ' => 'a',
            'إ' => 'i',
            'آ' => 'ā',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testSpecialCharacters(): void
    {
        $testCases = [
            'ة' => 'ẗ',
            'ى' => 'á',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testShadda(): void
    {
        $testCases = [
            'مّ' => 'mm',
            'بّ' => 'bb',
            'سّ' => 'ss',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testArabicNumbers(): void
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
            '٠١٢٣٤٥٦٧٨٩' => '0123456789',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testPunctuation(): void
    {
        $testCases = [
            '،' => ',',
            '؛' => ';',
            '؟' => '?',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testWords(): void
    {
        $testCases = [
            'كتاب' => 'ktāb',
            'مكتبة' => 'mktbẗ',
            'قلم' => 'qlm',
            'بيت' => 'byt',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testDefiniteArticleMoonLetters(): void
    {
        $testCases = [
            'الكتاب' => 'al-ktāb',
            'القلم' => 'al-qlm',
            'البيت' => 'al-byt',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testDefiniteArticleSunLetters(): void
    {
        $testCases = [
            'الشمس' => 'aš-šms',
            'النور' => 'an-nwr',
            'الرجل' => 'ar-rǧl',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testCommonPhrases(): void
    {
        $testCases = [
            'السلام عليكم' => 'as-slām ʿlykm',
            'مرحبا' => 'mrḥbā',
            'شكرا' => 'škrā',
        ];
        
        foreach ($testCases as $arabic => $expected) {
            $result = $this->converter->convert($arabic);
            $this->assertEquals($expected, $result);
        }
    }
    
    public function testEmptyString(): void
    {
        $result = $this->converter->convert('');
        $this->assertEquals('', $result);
    }
    
    public function testMixedContent(): void
    {
        $text = 'Hello مرحبا World';
        $result = $this->converter->convert($text);
        
        $this->assertStringContainsString('mrḥbā', $result);
        $this->assertStringContainsString('Hello', $result);
        $this->assertStringContainsString('World', $result);
    }
    
    public function testConvertWordMethod(): void
    {
        $result = $this->converter->convertWord('كتاب');
        $this->assertEquals('ktāb', $result);
    }
    
    public function testConvertTextMethod(): void
    {
        $result = $this->converter->convertText('السلام عليكم');
        $this->assertEquals('as-slām ʿlykm', $result);
    }
    
    public function testGetVersion(): void
    {
        $version = $this->converter->getVersion();
        $this->assertNotEmpty($version);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', $version);
    }
    
    public function testGetTransliterationMap(): void
    {
        $map = $this->converter->getTransliterationMap();
        $this->assertIsArray($map);
        $this->assertNotEmpty($map);
        $this->assertArrayHasKey('ا', $map);
        $this->assertArrayHasKey('ب', $map);
    }
}
