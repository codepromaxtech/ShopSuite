<?php
$files = ['public/css/modern-pages.css', 'public/css/modern-pos.css'];
foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $css = file_get_contents($file);
    // Fix dangling properties like `border- }` or `background- }`
    $css = preg_replace('/([a-z\-]+)\-\s*}/', '}', $css);
    // Fix empty media queries or selector rules
    $css = preg_replace('/\[data-theme="dark"\] \.card\[style\*\="\s*}/s', '', $css);
    $css = preg_replace('/\[data-theme="dark"\] \.card\[style\*\="[^\]]*}/s', '', $css);
    file_put_contents($file, $css);
}
echo "Fixed CSS structure for both files\n";
