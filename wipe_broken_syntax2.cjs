const fs = require('fs');
let content = fs.readFileSync('public/css/modern-pages.css', 'utf8');

// The broken snippet between lines 2076 and 2090.
let broken = `.report-title p {
    font-size: 14px;

}

padding: 10px;
text-align: left;
font-weight: bold;
font-size: 12px;
}
}

tbody tr:nth-child(even) {}

thead {}`;

let fix = `.report-title p {
    font-size: 14px;
}

th {
    padding: 10px;
    text-align: left;
    font-weight: bold;
    font-size: 12px;
}`;

content = content.replace(/\.report-title p \{\s*font-size: 14px;\s*\}\s*padding: 10px;\s*text-align: left;\s*font-weight: bold;\s*font-size: 12px;\s*\}\s*\}\s*tbody tr:nth-child\(even\) \{\}\s*thead \{\}/g, fix);
fs.writeFileSync('public/css/modern-pages.css', content);
