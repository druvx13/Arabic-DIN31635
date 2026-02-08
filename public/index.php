<?php
/**
 * Web Interface for Arabic to DIN 31635 Converter
 * 
 * A professional web-based tool for converting Arabic text to DIN 31635 transliteration.
 * Designed for LAMP stack deployment.
 */

require_once __DIR__ . '/../src/ArabicDIN31635Converter.php';

use ArabicDIN31635\ArabicDIN31635Converter;

// Handle AJAX conversion requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['arabic_text'])) {
    header('Content-Type: application/json; charset=utf-8');
    
    $converter = new ArabicDIN31635Converter();
    $arabicText = $_POST['arabic_text'] ?? '';
    $result = $converter->convert($arabicText);
    
    echo json_encode([
        'success' => true,
        'input' => $arabicText,
        'output' => $result
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arabic to DIN 31635 Converter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2.5em;
            text-align: center;
        }
        
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        
        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        .info-box p {
            color: #555;
            line-height: 1.6;
        }
        
        .converter-section {
            margin-bottom: 30px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1.1em;
            font-family: 'Arial', sans-serif;
            resize: vertical;
            transition: border-color 0.3s;
        }
        
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        #arabic_input {
            direction: rtl;
            text-align: right;
        }
        
        #transliteration_output {
            background: #f9f9f9;
            direction: ltr;
            text-align: left;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }
        
        button {
            flex: 1;
            padding: 15px 30px;
            font-size: 1.1em;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-convert {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-convert:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-clear {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-clear:hover {
            background: #e0e0e0;
        }
        
        .btn-copy {
            background: #28a745;
            color: white;
        }
        
        .btn-copy:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .examples {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }
        
        .examples h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .example-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .example-item:hover {
            background: #e8f0fe;
        }
        
        .example-arabic {
            font-size: 1.2em;
            direction: rtl;
            text-align: right;
            margin-bottom: 5px;
        }
        
        .example-transliteration {
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 0.9em;
        }
        
        .status-message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: none;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Arabic to DIN 31635 Converter</h1>
        <p class="subtitle">Professional transliteration tool for LAMP stack</p>
        
        <div class="info-box">
            <p><strong>DIN 31635</strong> is the German standard for transliterating Arabic script into Latin script. 
            This tool provides accurate, professional-grade conversion for bibliographic and academic purposes.</p>
        </div>
        
        <div id="status-message" class="status-message"></div>
        
        <div class="converter-section">
            <label for="arabic_input">Arabic Text (اكتب النص العربي هنا):</label>
            <textarea id="arabic_input" placeholder="أدخل النص العربي هنا..."></textarea>
        </div>
        
        <div class="button-group">
            <button class="btn-convert" onclick="convertText()">Convert to DIN 31635</button>
            <button class="btn-clear" onclick="clearAll()">Clear All</button>
        </div>
        
        <div class="converter-section">
            <label for="transliteration_output">DIN 31635 Transliteration:</label>
            <textarea id="transliteration_output" readonly placeholder="Transliteration will appear here..."></textarea>
        </div>
        
        <div class="button-group">
            <button class="btn-copy" onclick="copyToClipboard()">Copy Transliteration</button>
        </div>
        
        <div class="examples">
            <h3>Click on examples to try:</h3>
            <div class="example-item" onclick="useExample('السلام عليكم')">
                <div class="example-arabic">السلام عليكم</div>
                <div class="example-transliteration">as-salām ʿalaykum (Peace be upon you)</div>
            </div>
            <div class="example-item" onclick="useExample('مرحبا')">
                <div class="example-arabic">مرحبا</div>
                <div class="example-transliteration">marḥaban (Hello/Welcome)</div>
            </div>
            <div class="example-item" onclick="useExample('شكرا')">
                <div class="example-arabic">شكرا</div>
                <div class="example-transliteration">šukran (Thank you)</div>
            </div>
            <div class="example-item" onclick="useExample('الكتاب')">
                <div class="example-arabic">الكتاب</div>
                <div class="example-transliteration">al-kitāb (The book)</div>
            </div>
            <div class="example-item" onclick="useExample('القرآن الكريم')">
                <div class="example-arabic">القرآن الكريم</div>
                <div class="example-transliteration">al-Qurʾān al-Karīm (The Holy Quran)</div>
            </div>
        </div>
        
        <div class="footer">
            <p>© 2024 Arabic-DIN31635 Converter v1.0.0 | Built for LAMP Stack</p>
        </div>
    </div>
    
    <script>
        function convertText() {
            const arabicText = document.getElementById('arabic_input').value;
            
            if (!arabicText.trim()) {
                showStatus('Please enter Arabic text to convert.', 'error');
                return;
            }
            
            // Using AJAX for conversion
            const formData = new FormData();
            formData.append('arabic_text', arabicText);
            
            fetch('index.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('transliteration_output').value = data.output;
                    showStatus('Conversion successful!', 'success');
                } else {
                    showStatus('Conversion failed. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('An error occurred. Please try again.', 'error');
            });
        }
        
        function clearAll() {
            document.getElementById('arabic_input').value = '';
            document.getElementById('transliteration_output').value = '';
            hideStatus();
        }
        
        function copyToClipboard() {
            const output = document.getElementById('transliteration_output');
            
            if (!output.value.trim()) {
                showStatus('Nothing to copy. Please convert text first.', 'error');
                return;
            }
            
            output.select();
            document.execCommand('copy');
            showStatus('Transliteration copied to clipboard!', 'success');
        }
        
        function useExample(text) {
            document.getElementById('arabic_input').value = text;
            convertText();
        }
        
        function showStatus(message, type) {
            const statusDiv = document.getElementById('status-message');
            statusDiv.textContent = message;
            statusDiv.className = 'status-message status-' + type;
            statusDiv.style.display = 'block';
            
            setTimeout(() => {
                hideStatus();
            }, 3000);
        }
        
        function hideStatus() {
            const statusDiv = document.getElementById('status-message');
            statusDiv.style.display = 'none';
        }
        
        // Allow Enter key to trigger conversion (Ctrl+Enter in textarea)
        document.getElementById('arabic_input').addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                convertText();
            }
        });
    </script>
</body>
</html>
