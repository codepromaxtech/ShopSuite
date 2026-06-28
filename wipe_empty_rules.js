const fs = require('fs');
let content = fs.readFileSync('public/css/modern-pages.css', 'utf8');

// fix line 643
content = content.replace('border- box-shadow:', 'box-shadow:');

// fix empty blocks where possible quickly
content = content.replace(/\{(\s*)\}/g, '{}');

fs.writeFileSync('public/css/modern-pages.css', content);
