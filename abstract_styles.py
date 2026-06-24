import os
import re

views_dir = '/home/erp/ShopSuite/app/Views'
css_file = '/home/erp/ShopSuite/public/css/modern-pages.css'
extracted_css = "\n\n/* ==========================================\n   EXTRACTED INLINE STYLES FROM VIEWS\n   ========================================== */\n"
count = 0

for root, _, files in os.walk(views_dir):
    for filename in files:
        if filename.endswith('.php') and filename != 'login_modern.php': 
            filepath = os.path.join(root, filename)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            new_content = content
            matches = re.finditer(r'<style\b[^>]*>(.*?)</style>', content, re.DOTALL | re.IGNORECASE)
            
            modified = False
            for match in matches:
                style_block = match.group(1)
                full_match = match.group(0)
                
                if '<?' in style_block:
                    continue
                
                extracted_css += f"\n/* From: {os.path.basename(filename)} */\n"
                extracted_css += style_block.strip() + "\n"
                
                new_content = new_content.replace(full_match, '')
                modified = True
            
            if modified:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                count += 1
                print(f"Extracted styles from: {filename}")

with open(css_file, 'a', encoding='utf-8') as f:
    f.write(extracted_css)

print(f"Done extracting styles from {count} files!")
