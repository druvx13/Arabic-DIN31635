<?php
/**
 * Arabic to DIN 31635 Transliteration Converter
 * 
 * A professional PHP class for converting Arabic text to DIN 31635 Latin transliteration.
 * DIN 31635 is a standard for the transliteration of the Arabic alphabet adopted by 
 * the Deutsches Institut für Normung (German Institute for Standardization).
 * 
 * @author    Arabic-DIN31635 Project
 * @license   MIT
 * @version   1.0.0
 */

namespace ArabicDIN31635;

class ArabicDIN31635Converter
{
    /**
     * DIN 31635 transliteration mapping table
     * Complete coverage of Arabic Unicode characters
     * 
     * @var array
     */
    private const TRANSLITERATION_MAP = [
        // Basic Arabic Letters (U+0621 to U+063A)
        'ء' => 'ʾ',  // U+0621 hamza
        'آ' => 'ʾā', // U+0622 alif with madda above
        'أ' => 'ʾa', // U+0623 alif with hamza above
        'ؤ' => 'ʾu', // U+0624 waw with hamza above
        'إ' => 'ʾi', // U+0625 alif with hamza below
        'ئ' => 'ʾ',  // U+0626 ya with hamza above
        'ا' => 'ā',  // U+0627 alif
        'ب' => 'b',  // U+0628 ba
        'ة' => 'ẗ',  // U+0629 ta marbuta
        'ت' => 't',  // U+062A ta
        'ث' => 'ṯ',  // U+062B tha
        'ج' => 'ǧ',  // U+062C jim
        'ح' => 'ḥ',  // U+062D ha
        'خ' => 'ḫ',  // U+062E kha
        'د' => 'd',  // U+062F dal
        'ذ' => 'ḏ',  // U+0630 dhal
        'ر' => 'r',  // U+0631 ra
        'ز' => 'z',  // U+0632 zay
        'س' => 's',  // U+0633 sin
        'ش' => 'š',  // U+0634 shin
        'ص' => 'ṣ',  // U+0635 sad
        'ض' => 'ḍ',  // U+0636 dad
        'ط' => 'ṭ',  // U+0637 ta
        'ظ' => 'ẓ',  // U+0638 za
        'ع' => 'ʿ',  // U+0639 ayn
        'غ' => 'ġ',  // U+063A ghayn
        
        // Additional Arabic Letters (U+063B to U+0652)
        'ف' => 'f',  // U+0641 fa
        'ق' => 'q',  // U+0642 qaf
        'ك' => 'k',  // U+0643 kaf
        'ل' => 'l',  // U+0644 lam
        'م' => 'm',  // U+0645 mim
        'ن' => 'n',  // U+0646 nun
        'ه' => 'h',  // U+0647 ha
        'و' => 'w',  // U+0648 waw
        'ى' => 'á',  // U+0649 alif maqsura
        'ي' => 'y',  // U+064A ya
        
        // Vowels and Diacritical Marks (U+064B to U+0652)
        'ً' => 'an', // U+064B fathatan
        'ٌ' => 'un', // U+064C dammatan
        'ٍ' => 'in', // U+064D kasratan
        'َ' => 'a',  // U+064E fatha
        'ُ' => 'u',  // U+064F damma
        'ِ' => 'i',  // U+0650 kasra
        'ّ' => '',   // U+0651 shadda (handled specially)
        'ْ' => '',   // U+0652 sukun
        
        // Additional Marks
        'ٓ' => '',   // U+0653 maddah above
        'ٔ' => 'ʾ',  // U+0654 hamza above
        'ٕ' => 'ʾ',  // U+0655 hamza below
        'ٖ' => '',   // U+0656 subscript alif
        'ٗ' => '',   // U+0657 inverted damma
        '٘' => '',   // U+0658 mark noon ghunna
        'ٙ' => '',   // U+0659 zwarakay
        'ٚ' => '',   // U+065A vowel sign small v above
        'ٛ' => '',   // U+065B vowel sign inverted small v above
        'ٜ' => '',   // U+065C vowel sign dot below
        'ٝ' => '',   // U+065D reversed damma
        'ٞ' => 'a',  // U+065E fatha with two dots
        'ٟ' => '',   // U+065F wavy hamza below
        
        // Extended Arabic (U+0660 to U+066D)
        '٠' => '0',  // U+0660 Arabic-Indic digit zero
        '١' => '1',  // U+0661 Arabic-Indic digit one
        '٢' => '2',  // U+0662 Arabic-Indic digit two
        '٣' => '3',  // U+0663 Arabic-Indic digit three
        '٤' => '4',  // U+0664 Arabic-Indic digit four
        '٥' => '5',  // U+0665 Arabic-Indic digit five
        '٦' => '6',  // U+0666 Arabic-Indic digit six
        '٧' => '7',  // U+0667 Arabic-Indic digit seven
        '٨' => '8',  // U+0668 Arabic-Indic digit eight
        '٩' => '9',  // U+0669 Arabic-Indic digit nine
        '٪' => '%',  // U+066A Arabic percent sign
        '٫' => '.',  // U+066B Arabic decimal separator
        '٬' => ',',  // U+066C Arabic thousands separator
        '٭' => '*',  // U+066D Arabic five pointed star
        
        // Arabic Punctuation
        '؞' => '',   // U+061E triple dot punctuation mark
        '؟' => '?',  // U+061F Arabic question mark
        '؛' => ';',  // U+061B Arabic semicolon
        '،' => ',',  // U+060C Arabic comma
        
        // Special Characters
        'ـ' => '',   // U+0640 tatweel (kashida)
        '۞' => '',   // U+06DE start of rub el hizb
        '﴾' => '(',  // U+FD3E ornate left parenthesis
        '﴿' => ')',  // U+FD3F ornate right parenthesis
        '«' => '«',  // U+00AB left guillemet
        '»' => '»',  // U+00BB right guillemet
        
        // Persian/Urdu Extensions (for completeness)
        'پ' => 'p',  // U+067E pe
        'چ' => 'č',  // U+0686 che
        'ژ' => 'ž',  // U+0698 zhe
        'ک' => 'k',  // U+06A9 keheh
        'گ' => 'g',  // U+06AF gaf
        'ں' => 'n',  // U+06BA noon ghunna
        'ھ' => 'h',  // U+06BE heh doachashmee
        'ہ' => 'h',  // U+06C1 heh goal
        'ی' => 'y',  // U+06CC Farsi yeh
        'ے' => 'y',  // U+06D2 yeh barree
    ];
    
    /**
     * Sun letters for definite article assimilation
     * 
     * @var array
     */
    private const AL_SHAMSIYA = ['ت', 'ث', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ل', 'ن'];
    
    /**
     * Convert Arabic text to DIN 31635 transliteration
     * 
     * @param string $arabicText The Arabic text to transliterate
     * @return string The transliterated text in DIN 31635 format
     */
    public function convert(string $arabicText): string
    {
        if (empty($arabicText)) {
            return '';
        }
        
        $result = [];
        $chars = $this->mb_str_split($arabicText);
        $length = count($chars);
        $i = 0;
        
        while ($i < $length) {
            $char = $chars[$i];
            
            // Handle shadda (gemination)
            if ($i + 1 < $length && $chars[$i + 1] === 'ّ') {
                $trans = self::TRANSLITERATION_MAP[$char] ?? $char;
                // Double the consonant for shadda
                $result[] = $trans . $trans;
                $i += 2;
                continue;
            }
            
            // Handle definite article ال (al-)
            if ($i + 1 < $length && $char === 'ا' && $chars[$i + 1] === 'ل') {
                // Check if followed by sun letter
                if ($i + 2 < $length && in_array($chars[$i + 2], self::AL_SHAMSIYA)) {
                    $sunLetter = self::TRANSLITERATION_MAP[$chars[$i + 2]] ?? $chars[$i + 2];
                    // Sun letter assimilation: the 'l' of 'al' assimilates to the following sun letter
                    $result[] = 'a' . $sunLetter . $sunLetter . '-';
                    $i += 3;  // Skip article + first occurrence of sun letter
                    continue;
                } else {
                    $result[] = 'al-';
                    $i += 2;
                    continue;
                }
            }
            
            // Standard character transliteration
            $result[] = self::TRANSLITERATION_MAP[$char] ?? $char;
            $i++;
        }
        
        return implode('', $result);
    }
    
    /**
     * Convert a single Arabic word to DIN 31635 transliteration
     * 
     * @param string $arabicWord A single Arabic word
     * @return string The transliterated word
     */
    public function convertWord(string $arabicWord): string
    {
        return $this->convert($arabicWord);
    }
    
    /**
     * Convert Arabic text (multiple words) to DIN 31635 transliteration
     * Preserves spaces and basic structure
     * 
     * @param string $arabicText The Arabic text to transliterate
     * @return string The transliterated text
     */
    public function convertText(string $arabicText): string
    {
        return $this->convert($arabicText);
    }
    
    /**
     * Split a multibyte string into an array of characters
     * 
     * @param string $string The string to split
     * @return array Array of characters
     */
    private function mb_str_split(string $string): array
    {
        return preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
    
    /**
     * Get the transliteration mapping table
     * 
     * @return array The complete mapping table
     */
    public function getTransliterationMap(): array
    {
        return self::TRANSLITERATION_MAP;
    }
    
    /**
     * Get version information
     * 
     * @return string Version number
     */
    public function getVersion(): string
    {
        return '1.0.0';
    }
}
