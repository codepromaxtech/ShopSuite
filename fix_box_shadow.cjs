const fs = require('fs');
let content = fs.readFileSync('public/css/modern-pages.css', 'utf8');

content = content.replace(/border- box-shadow:/g, 'box-shadow:');

fs.writeFileSync('public/css/modern-pages.css', content);
