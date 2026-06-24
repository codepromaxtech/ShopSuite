import re
import os

php_file = '/home/erp/ShopSuite/app/Views/login_modern.php'
css_file = '/home/erp/ShopSuite/public/css/login-modern.css'

# Update PHP file
with open(php_file, 'r', encoding='utf-8') as f:
    php_content = f.read()

php_content = php_content.replace('style="position: relative; overflow: hidden; "', 'class="visual-container"')
php_content = php_content.replace('style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; gap: 8px;"', 'class="visual-card-header"')
php_content = php_content.replace('style="padding: 20px; display: grid; gap: 15px;"', 'class="visual-card-body-grid"')
php_content = php_content.replace('style="height: 20px; background: rgba(255,255,255,0.1); border-radius: 4px; width: 60%;"', 'class="placeholder-bar mb-60"')
php_content = php_content.replace('style="height: 20px; background: rgba(255,255,255,0.05); border-radius: 4px; width: 80%;"', 'class="placeholder-bar mb-80"')
php_content = php_content.replace('style="height: 60px; background: rgba(255,255,255,0.05); border-radius: 8px; width: 100%;"', 'class="placeholder-box"')

php_content = php_content.replace('style="padding: 20px; display: flex; align-items: center; gap: 15px;"', 'class="visual-card-body-flex"')
php_content = php_content.replace('style="width: 50px; height: 50px; border-radius: 12px; background: var(--primary-500); display: flex; align-items: center; justify-content: center; "', 'class="stat-icon-box"')
php_content = php_content.replace('style=" font-weight: bold; font-size: 1.2rem;"', 'class="stat-title"')
php_content = php_content.replace('style="color: rgba(255,255,255,0.5); font-size: 0.85rem;"', 'class="stat-subtitle"')

php_content = php_content.replace('style="z-index: 10; width: 100%; max-width: 500px; margin: auto; position: relative;"', 'class="visual-hero-text"')
php_content = php_content.replace('style="height: 48px; border-radius: 8px;"', '')
php_content = php_content.replace('style="display: flex; justify-content: space-between; align-items: center; font-size: var(--text-sm);"', '')
php_content = php_content.replace('style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer; color: var(--text-secondary);"', '')
php_content = php_content.replace('style="accent-color: var(--primary-600); width: 16px; height: 16px;"', '')
php_content = php_content.replace('style="color: var(--primary-600); text-decoration: none; font-weight: 500;"', '')
php_content = php_content.replace('style="display: flex; justify-content: center; margin-bottom: var(--space-6);"', 'class="d-flex justify-content-center mb-4"')
php_content = php_content.replace('style="text-align: center; color: var(--text-tertiary); font-size: var(--text-sm); margin-top: var(--space-8);"', 'class="login-footer"')

php_content = php_content.replace('style="width: 12px; height: 12px; border-radius: 50%; background-color: var(--danger-500);"', 'class="mac-btn close-btn"')
php_content = php_content.replace('style="width: 12px; height: 12px; border-radius: 50%; background-color: var(--warning-500);"', 'class="mac-btn minimize-btn"')
php_content = php_content.replace('style="width: 12px; height: 12px; border-radius: 50%; background-color: var(--success-500);"', 'class="mac-btn maximize-btn"')


with open(php_file, 'w', encoding='utf-8') as f:
    f.write(php_content)

# Update CSS file
css_additions = """
/* Login Abstraction Extensions */
.visual-container {
    position: relative; 
    overflow: hidden;
}

.visual-card-header {
    padding: 15px; 
    border-bottom: 1px solid rgba(255,255,255,0.05); 
    display: flex; 
    gap: 8px;
}

.mac-btn {
    width: 12px; 
    height: 12px; 
    border-radius: 50%;
}
.close-btn { background-color: var(--danger-500); }
.minimize-btn { background-color: var(--warning-500); }
.maximize-btn { background-color: var(--success-500); }

.visual-card-body-grid {
    padding: 20px; 
    display: grid; 
    gap: 15px;
}

.visual-card-body-flex {
    padding: 20px; 
    display: flex; 
    align-items: center; 
    gap: 15px;
}

.placeholder-bar {
    height: 20px; 
    border-radius: 4px;
}
.mb-60 { background: rgba(255,255,255,0.1); width: 60%; }
.mb-80 { background: rgba(255,255,255,0.05); width: 80%; }

.placeholder-box {
    height: 60px; 
    background: rgba(255,255,255,0.05); 
    border-radius: 8px; 
    width: 100%;
}

.stat-icon-box {
    width: 50px; 
    height: 50px; 
    border-radius: 12px; 
    background: var(--primary-500); 
    display: flex; 
    align-items: center; 
    justify-content: center;
}

.stat-title {
    font-weight: bold; 
    font-size: 1.2rem;
}

.stat-subtitle {
    color: rgba(255,255,255,0.5); 
    font-size: 0.85rem;
}

.visual-hero-text {
    z-index: 10; 
    width: 100%; 
    max-width: 500px; 
    margin: auto; 
    position: relative;
}

.login-footer {
    text-align: center; 
    color: var(--text-tertiary); 
    font-size: var(--text-sm); 
    margin-top: var(--space-8);
}
"""

with open(css_file, 'a', encoding='utf-8') as f:
    f.write(css_additions)
