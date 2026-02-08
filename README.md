# Arabic to DIN 31635 Converter

A professional and perfect tool for converting Arabic text into DIN 31635 Latin transliteration. Built for LAMP (Linux, Apache, MySQL, PHP) stack environments.

## Features

✨ **Complete Arabic Support**
- All 28 Arabic letters
- Hamza variants (ء، أ، إ، آ، ؤ، ئ)
- Diacritical marks (fatha, kasra, damma, tanween, sukun, shadda)
- Special characters (ta marbuta, alif maqsura)
- Arabic-Indic numerals (٠-٩)
- Arabic punctuation marks

🎯 **DIN 31635 Standard Compliance**
- Precise character mapping according to DIN 31635
- Proper handling of definite article (ال) with sun and moon letters
- Shadda (gemination) support
- Special character transliteration

🚀 **Multiple Interfaces**
- Web-based UI (perfect for LAMP stack)
- Command-line tool (CLI)
- PHP library for integration

## Installation

### For LAMP Stack

1. Clone the repository into your web server directory:
```bash
cd /var/www/html
git clone https://github.com/druvx13/Arabic-DIN31635.git
```

2. Configure Apache to serve from the `public` directory or use the included `.htaccess` file.

3. Access the web interface at `http://your-domain/Arabic-DIN31635/public/`

### For PHP Projects

Include the converter in your project:

```php
require_once 'path/to/src/ArabicDIN31635Converter.php';
use ArabicDIN31635\ArabicDIN31635Converter;

$converter = new ArabicDIN31635Converter();
$result = $converter->convert('مرحبا');
echo $result; // Output: mrḥbā
```

## Usage

### Web Interface

1. Open `public/index.php` in your web browser
2. Type or paste Arabic text in the input field
3. Click "Convert to DIN 31635"
4. Copy the transliterated result

### Command Line

```bash
# Convert text directly
php bin/convert.php "السلام عليكم"

# Convert from file
php bin/convert.php -f input.txt

# Save output to file
php bin/convert.php -f input.txt -o output.txt

# Use with pipes
echo "مرحبا" | php bin/convert.php

# Show help
php bin/convert.php --help

# Show version
php bin/convert.php --version
```

### PHP Library

```php
<?php
require_once 'src/ArabicDIN31635Converter.php';
use ArabicDIN31635\ArabicDIN31635Converter;

$converter = new ArabicDIN31635Converter();

// Convert single word
$word = $converter->convert('كتاب');
// Result: ktāb

// Convert phrase
$phrase = $converter->convert('السلام عليكم');
// Result: ass-lām ʿlykm

// Convert text with numbers
$text = $converter->convert('سنة ٢٠٢٤');
// Result: snẗ 2024
```

## Examples

### Basic Conversions

| Arabic | DIN 31635 |
|--------|-----------|
| مرحبا | mrḥbā |
| شكرا | škrā |
| السلام عليكم | ass-lām ʿlykm |
| الحمد لله | al-ḥmd llh |

### Definite Article

**Moon Letters** (no assimilation):
| Arabic | DIN 31635 |
|--------|-----------|
| الكتاب | al-ktāb |
| القلم | al-qlm |
| البيت | al-byt |

**Sun Letters** (with assimilation):
| Arabic | DIN 31635 |
|--------|-----------|
| الشمس | ašš-ms |
| النور | ann-wr |
| الرحمن | arr-ḥmn |

### Special Features

**Shadda (Gemination)**:
| Arabic | DIN 31635 |
|--------|-----------|
| محمّد | mḥmmd |
| مكّة | mkk-ẗ |

**Numbers**:
| Arabic | DIN 31635 |
|--------|-----------|
| ٠١٢٣٤٥٦٧٨٩ | 0123456789 |
| ٢٠٢٤ | 2024 |

## DIN 31635 Transliteration Table

### Consonants
| Arabic | DIN 31635 | Name |
|--------|-----------|------|
| ء | ʾ | hamza |
| ب | b | ba |
| ت | t | ta |
| ث | ṯ | tha |
| ج | ǧ | jim |
| ح | ḥ | ha |
| خ | ḫ | kha |
| د | d | dal |
| ذ | ḏ | dhal |
| ر | r | ra |
| ز | z | zay |
| س | s | sin |
| ش | š | shin |
| ص | ṣ | sad |
| ض | ḍ | dad |
| ط | ṭ | ta |
| ظ | ẓ | za |
| ع | ʿ | ayn |
| غ | ġ | ghayn |
| ف | f | fa |
| ق | q | qaf |
| ك | k | kaf |
| ل | l | lam |
| م | m | mim |
| ن | n | nun |
| ه | h | ha |
| و | w | waw |
| ي | y | ya |

### Vowels and Diacritics
| Arabic | DIN 31635 | Name |
|--------|-----------|------|
| َ | a | fatha |
| ُ | u | damma |
| ِ | i | kasra |
| ً | an | fathatan |
| ٌ | un | dammatan |
| ٍ | in | kasratan |
| ْ | - | sukun |
| ّ | doubled | shadda |

## Testing

The package includes comprehensive tests covering:
- All Arabic consonants
- All diacritical marks
- Shadda with every consonant
- Definite article with all sun and moon letters
- Arabic-Indic numerals
- Punctuation marks
- Common words and phrases
- Geographic and personal names
- Edge cases and special scenarios

Run tests (requires PHPUnit):
```bash
composer install
composer test
```

Or run manual tests:
```bash
php examples/basic_usage.php
```

## Requirements

- PHP 8.0 or higher
- mbstring extension (for Unicode support)
- Apache web server (for LAMP deployment)

## Apache Configuration

The included `.htaccess` file configures:
- UTF-8 character encoding
- Security headers
- GZIP compression
- Static file caching

## Project Structure

```
Arabic-DIN31635/
├── src/
│   └── ArabicDIN31635Converter.php  # Main converter class
├── public/
│   └── index.php                     # Web interface
├── bin/
│   └── convert.php                   # CLI tool
├── tests/
│   ├── ArabicDIN31635ConverterTest.php
│   └── ComprehensiveTest.php
├── examples/
│   └── basic_usage.php
├── .htaccess                         # Apache configuration
├── composer.json                     # PHP dependencies
├── phpunit.xml                       # PHPUnit configuration
└── README.md                         # This file
```

## Contributing

Contributions are welcome! Please ensure:
1. All tests pass
2. Code follows PSR-12 coding standards
3. New features include appropriate tests
4. Documentation is updated

## License

MIT License - feel free to use in your projects!

## About DIN 31635

DIN 31635 is the German standard (Deutsche Industrie Norm) for the transliteration of the Arabic alphabet into Latin script. It's widely used in:
- Academic publications
- Library cataloging
- Bibliographic references
- Scholarly works on Arabic texts

## Author

Arabic-DIN31635 Project

## Version

1.0.0

## Support

For issues, questions, or contributions, please visit:
https://github.com/druvx13/Arabic-DIN31635
