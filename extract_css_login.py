import re

php_file = '/home/erp/ShopSuite/app/Views/login_modern.php'
css_file = '/home/erp/ShopSuite/public/css/login-modern.css'

with open(php_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Extract <style> ... </style>
style_match = re.search(r'<style>(.*?)</style>', content, re.DOTALL)
if style_match:
    css_content = style_match.group(1).strip()
    content = content.replace(style_match.group(0), '')
else:
    css_content = ''

# Extract JS injected style
js_style_match = re.search(r"const style = document.createElement\('style'\);\s*style\.innerHTML = `(.*?)`;\s*document\.head\.appendChild\(style\);", content, re.DOTALL)
if js_style_match:
    js_css = js_style_match.group(1).strip()
    css_content += '\n\n/* JS Animations */\n' + js_css
    content = content.replace(js_style_match.group(0), '')

# Add visual card classes
css_content += '''

/* Visual Cards extracted from inline styles */
.visual-card-1 {
    position: absolute; 
    top: 15%; 
    right: -10%; 
    width: 400px; 
    height: 250px; 
    background: rgba(255,255,255,0.03); 
    border: 1px solid rgba(255,255,255,0.1); 
    border-radius: 20px; 
    backdrop-filter: blur(10px); 
    transform: rotate(-5deg); 
    box-shadow: 0 25px 50px rgba(0,0,0,0.3); 
    z-index: 1;
}

.visual-card-2 {
    position: absolute; 
    bottom: 15%; 
    left: 10%; 
    width: 300px; 
    height: 150px; 
    background: rgba(255,255,255,0.03); 
    border: 1px solid rgba(255,255,255,0.1); 
    border-radius: 20px; 
    backdrop-filter: blur(10px); 
    transform: rotate(5deg); 
    box-shadow: 0 25px 50px rgba(0,0,0,0.3); 
    z-index: 2;
}
'''

# Write to CSS file
with open(css_file, 'w', encoding='utf-8') as f:
    f.write(css_content)

# Replace inline styles with classes
content = content.replace('style="position: absolute; top: 15%; right: -10%; width: 400px; height: 250px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); transform: rotate(-5deg); box-shadow: 0 25px 50px rgba(0,0,0,0.3); z-index: 1;"', 'class="visual-card-1"')
content = content.replace('style="position: absolute; bottom: 15%; left: 10%; width: 300px; height: 150px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); transform: rotate(5deg); box-shadow: 0 25px 50px rgba(0,0,0,0.3); z-index: 2;"', 'class="visual-card-2"')

# Insert the link tag after components.css
content = content.replace('<link rel="stylesheet" href="<?= base_url(\'css/components.css\') ?>">', 
                          '<link rel="stylesheet" href="<?= base_url(\'css/components.css\') ?>">\n    <link rel="stylesheet" href="<?= base_url(\'css/login-modern.css\') ?>?v=1.0">')

with open(php_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Done extracting CSS to login-modern.css")
