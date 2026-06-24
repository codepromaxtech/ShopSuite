import re

php_file = '/home/erp/ShopSuite/app/Views/sales/register_modern.php'
css_file = '/home/erp/ShopSuite/public/css/pos-compact.css'

with open(php_file, 'r', encoding='utf-8') as f:
    content = f.read()

# JS strings
content = content.replace('style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer; transition: background var(--transition-fast);"', 'class="autocomplete-item"')
content = content.replace('style="font-weight: var(--font-semibold);"', 'class="fw-semibold"')
content = content.replace('style="font-size: var(--text-sm); color: var(--text-secondary);"', 'class="text-sm text-secondary"')
content = content.replace('style="padding: var(--space-4); text-align: center; color: var(--text-tertiary);"', 'class="p-4 text-center text-tertiary"')

# Layout and structural replacements
content = content.replace('style="display: flex; align-items: center; gap: var(--space-4);"', 'class="d-flex align-items-center gap-4"')
content = content.replace('style="display: flex; align-items: center; gap: var(--space-2);"', 'class="d-flex align-items-center gap-2"')
content = content.replace('style="margin: 0; font-size: var(--text-base); font-weight: var(--font-semibold); display: flex; align-items: center; gap: var(--space-2);"', 'class="cart-header-title"')
content = content.replace('style="color: var(--text-tertiary); font-weight: normal; font-size: var(--text-sm);"', 'class="cart-item-count"')
content = content.replace('style="font-size: var(--text-lg); font-weight: var(--font-semibold); margin-bottom: var(--space-2);"', 'class="empty-cart-title"')
content = content.replace('style="font-size: var(--text-sm);"', 'class="text-sm"')

content = content.replace('style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px;  border-radius: 6px; border: 1px solid #bae6fd; margin-bottom: 8px;"', 'class="customer-selected-card"')
content = content.replace('style="font-weight: 600;  font-size: 13px;"', 'class="customer-name"')
content = content.replace('style="font-size: 11px; "', 'class="customer-id"')
content = content.replace('style="margin-bottom: 8px;"', 'class="mb-2"')
content = content.replace('style="display: flex; align-items: center; padding: 6px 8px;  border-radius: 6px; border: 1px dashed #d1d5db;"', 'class="walk-in-card"')
content = content.replace('style="margin-right: 6px; "', 'class="mr-2"')
content = content.replace('style=" font-size: 12px;"', 'class="text-xs"')

content = content.replace('style="position: relative; margin-bottom: 6px;"', 'class="pos-search-wrapper"')
content = content.replace('style="font-size: 12px; padding: 6px 8px 6px 32px;"', 'class="customer-search-input"')
content = content.replace('style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); "', 'class="search-icon-abs"')
content = content.replace('style="font-size: 12px; padding: 6px 10px;"', 'class="text-xs py-1 px-2"')
content = content.replace('style="margin-right: 4px;"', 'class="mr-1"')

content = content.replace('style="font-weight: var(--font-bold);"', 'class="fw-bold"')
content = content.replace('style="color: var(--primary-600);"', 'class="text-primary-600"')
content = content.replace('style="margin-top: var(--space-3);"', 'class="mt-3"')
content = content.replace('style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);"', 'class="d-flex justify-content-between align-items-center mb-2"')
content = content.replace('style="margin: 0; font-size: var(--text-base);"', 'class="m-0 text-base"')
content = content.replace('style="font-size: var(--text-xs); font-weight: var(--font-bold); color: var(--danger);"', 'class="remaining-amount-text"')
content = content.replace('style="margin-bottom: var(--space-2); max-height: 80px; overflow-y: auto;"', 'class="payments-list-container"')
content = content.replace('style="padding: var(--space-2); background: var(--bg-secondary); border-radius: var(--radius-md); margin-bottom: var(--space-2);"', 'class="add-payment-card"')
content = content.replace('style="display: flex; gap: var(--space-2); margin-bottom: var(--space-2);"', 'class="d-flex gap-2 mb-2"')
content = content.replace('style="flex: 1;"', 'class="flex-1"')
content = content.replace('style="position: relative;"', 'class="position-relative"')
content = content.replace('style="position: absolute; left: var(--space-2); top: 50%; transform: translateY(-50%); color: var(--text-tertiary); font-weight: var(--font-semibold); font-size: var(--text-xs);"', 'class="currency-symbol"')
content = content.replace('style="padding-left: var(--space-5); font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1);"', 'class="payment-input"')
content = content.replace('style="font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1);"', 'class="payment-select"')
content = content.replace('style="font-size: var(--text-xs); padding: var(--space-1) var(--space-2); white-space: nowrap;"', 'class="btn-xs whitespace-nowrap"')
content = content.replace('style="display: flex; gap: var(--space-1);"', 'class="d-flex gap-1"')
content = content.replace('style="flex: 1; font-size: 10px; padding: 4px;"', 'class="btn-xxs flex-1"')
content = content.replace('style="vertical-align: middle; margin-right: var(--space-2);"', 'class="align-middle mr-2"')
content = content.replace('style="font-size: 12px;"', 'class="text-xs"')

# Fix inline JS templates
content = content.replace("style='padding: var(--space-4); text-align: center; color: var(--text-tertiary);'", 'class="p-4 text-center text-tertiary"')

with open(php_file, 'w', encoding='utf-8') as f:
    f.write(content)

css_additions = """
/* Auto-abstracted POS specific utility tags */
.autocomplete-item { padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer; transition: background var(--transition-fast); }
.fw-semibold { font-weight: var(--font-semibold); }
.text-sm { font-size: var(--text-sm); }
.text-secondary { color: var(--text-secondary); }
.p-4 { padding: var(--space-4); }
.text-center { text-align: center; }
.text-tertiary { color: var(--text-tertiary); }
.d-flex { display: flex; }
.align-items-center { align-items: center; }
.justify-content-between { justify-content: space-between; }
.gap-4 { gap: var(--space-4); }
.gap-2 { gap: var(--space-2); }
.gap-1 { gap: var(--space-1); }
.cart-header-title { margin: 0; font-size: var(--text-base); font-weight: var(--font-semibold); display: flex; align-items: center; gap: var(--space-2); }
.cart-item-count { color: var(--text-tertiary); font-weight: normal; font-size: var(--text-sm); }
.empty-cart-title { font-size: var(--text-lg); font-weight: var(--font-semibold); margin-bottom: var(--space-2); }
.customer-selected-card { display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; border-radius: 6px; border: 1px solid var(--primary-300); margin-bottom: 8px; }
.customer-name { font-weight: 600; font-size: 13px; }
.customer-id { font-size: 11px; }
.mb-2 { margin-bottom: 8px; }
.mt-3 { margin-top: var(--space-3); }
.walk-in-card { display: flex; align-items: center; padding: 6px 8px; border-radius: 6px; border: 1px dashed var(--border-color, #d1d5db); }
.mr-2 { margin-right: var(--space-2); }
.text-xs { font-size: 12px; }
.pos-search-wrapper { position: relative; margin-bottom: 6px; }
.customer-search-input { font-size: 12px; padding: 6px 8px 6px 32px; }
.search-icon-abs { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); }
.py-1 { padding-top: 4px; padding-bottom: 4px; }
.px-2 { padding-left: 8px; padding-right: 8px; }
.mr-1 { margin-right: 4px; }
.fw-bold { font-weight: var(--font-bold); }
.text-primary-600 { color: var(--primary-600); }
.m-0 { margin: 0; }
.text-base { font-size: var(--text-base); }
.remaining-amount-text { font-size: var(--text-xs); font-weight: var(--font-bold); color: var(--danger); }
.payments-list-container { margin-bottom: var(--space-2); max-height: 80px; overflow-y: auto; }
.add-payment-card { padding: var(--space-2); background: var(--bg-secondary); border-radius: var(--radius-md); margin-bottom: var(--space-2); }
.flex-1 { flex: 1; }
.position-relative { position: relative; }
.currency-symbol { position: absolute; left: var(--space-2); top: 50%; transform: translateY(-50%); color: var(--text-tertiary); font-weight: var(--font-semibold); font-size: var(--text-xs); }
.payment-input { padding-left: var(--space-5); font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1); }
.payment-select { font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1); }
.btn-xs { font-size: var(--text-xs); padding: var(--space-1) var(--space-2); }
.whitespace-nowrap { white-space: nowrap; }
.btn-xxs { font-size: 10px; padding: 4px; }
.align-middle { vertical-align: middle; }
"""

with open(css_file, 'a', encoding='utf-8') as f:
    f.write(css_additions)
print("done")
