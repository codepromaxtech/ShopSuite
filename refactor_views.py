import re
import os

views_dir = '/home/erp/ShopSuite/app/Views'

# Regex patterns to find and replace
replacements = [
    (r'\bbg-(white|light)\b', 'bg-primary'),
    (r'\bbg-dark\b', 'bg-tertiary'),
    (r'\btext-(dark|black)\b', 'text-primary'),
    (r'\btext-(muted|gray)\b', 'text-secondary'),
    # for inline color styles
    (r'color:\s*#[0-9a-fA-F]{3,6};?', ''),
    (r'color:\s*(white|black);?', ''),
    (r'background(?:-color)?:\s*#[0-9a-fA-F]{3,6};?', ''),
    (r'background(?:-color)?:\s*(white|black);?', ''),
    (r'background:\s*linear-gradient[^;]+;?', ''),
    # specific problematic classes
    (r'\bbg-primary\s+text-white\b', ''), # let it fall back
    (r'\btext-white\b', 'text-inverse'),
]

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.php'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            new_content = content
            for pat, rep in replacements:
                new_content = re.sub(pat, rep, new_content, flags=re.IGNORECASE)
            
            # Additional cleanup of empty style tags
            new_content = re.sub(r'style="\s*"', '', new_content)
            new_content = re.sub(r"style='\s*'", '', new_content)
            
            if new_content != content:
                with open(path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Refactored: {path}")
