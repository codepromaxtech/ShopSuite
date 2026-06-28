const fs = require('fs');
let content = fs.readFileSync('public/css/modern-pages.css', 'utf8');

// The broken snippet between lines 2046 and 2052.
let broken = `
margin-bottom: 30px;
border-bottom: 3px solid var(--primary-900);
padding-bottom: 20px;

padding: 20px;
}`;

let fix = `.header {
    margin-bottom: 30px;
    border-bottom: 3px solid var(--primary-900);
    padding-bottom: 20px;
}
.content {
    padding: 20px;
}`;

content = content.replace(/margin-bottom: 30px;\s*border-bottom: 3px solid var\(--primary-900\);\s*padding-bottom: 20px;\s*padding: 20px;\s*\}/g, fix);
fs.writeFileSync('public/css/modern-pages.css', content);
