const fs = require('fs');
let content = fs.readFileSync('public/css/modern-pages.css', 'utf8');

// fix line 643
content = content.replace('border- box-shadow:', 'box-shadow:');

// Regex to remove empty CSS rules: selector { } or missing closing braces that were messed up
// We'll just replace \s*{\s*} with {}
content = content.replace(/\{\s*\}/g, '{}');

// Fix receipt-success-header 
content = content.replace(/\.receipt-success-header\s*\{\s*padding: 40px 30px;/g, '.receipt-success-header {\n    padding: 40px 30px;');
// Fix success-icon background
content = content.replace(/background: rgba\(255, 255, 255, 0\.2\);/g, 'background: var(--success-100);\n    color: var(--success-600);');

fs.writeFileSync('public/css/modern-pages.css', content);
