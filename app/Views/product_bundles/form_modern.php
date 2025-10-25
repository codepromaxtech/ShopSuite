<?php
$title = ($item_kit_info->item_kit_id ? 'Edit' : 'Add') . ' Product Bundle - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            <div>
                <h1><?= $item_kit_info->item_kit_id ? 'Edit' : 'Add New' ?> Product Bundle</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('product_bundles') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Product Bundles
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('product_bundles') ?>">Product Bundles</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $item_kit_info->item_kit_id ? 'Edit' : 'Add' ?></div>
    </div>
</div>

<?= form_open('product_bundles/save/' . ($item_kit_info->item_kit_id ?? '-1'), ['id' => 'item_kit_form', 'class' => 'form-modern']) ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Basic Information -->
        <div class="card" style="margin-bottom: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label form-label-required">Kit Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($item_kit_info->name ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="item_kit_number" class="form-label">Kit Number/SKU</label>
                    <input type="text" class="form-control" id="item_kit_number" name="item_kit_number" value="<?= esc($item_kit_info->item_kit_number ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= esc($item_kit_info->description ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="kit_item_search" class="form-label">Kit Item</label>
                    <input type="text" class="form-control" id="kit_item_search" placeholder="Search for kit item..." value="<?= esc($selected_kit_item ?? '') ?>">
                    <input type="hidden" id="kit_item_id" name="kit_item_id" value="<?= esc($selected_kit_item_id ?? '') ?>">
                    <small class="form-text">Optional: Select an item to represent this kit</small>
                </div>
            </div>
        </div>
        
        <!-- Kit Items -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-header-title">Kit Items</h3>
                <button type="button" class="btn btn-sm btn-primary" onclick="addKitItem()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Item
                </button>
            </div>
            <div class="card-body">
                <div id="kit_items_container">
                    <?php if (!empty($item_kit_items)): ?>
                        <?php foreach ($item_kit_items as $index => $item): ?>
                            <div class="kit-item-row" data-index="<?= $index ?>">
                                <div class="grid grid-cols-12 gap-3" style="align-items: end;">
                                    <div class="col-span-6">
                                        <label class="form-label">Item</label>
                                        <input type="text" class="form-control" readonly value="<?= esc($item['name']) ?>">
                                        <input type="hidden" name="item_id[]" value="<?= esc($item['item_id']) ?>">
                                    </div>
                                    <div class="col-span-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="quantity[]" value="<?= esc($item['quantity']) ?>" min="1" step="0.01" required>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="form-label">Sequence</label>
                                        <input type="number" class="form-control" name="kit_sequence[]" value="<?= esc($item['kit_sequence']) ?>" min="0">
                                    </div>
                                    <div class="col-span-1">
                                        <button type="button" class="btn btn-outline btn-sm" onclick="removeKitItem(this)" style="width: 100%;">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div id="empty_state" style="<?= !empty($item_kit_items) ? 'display: none;' : '' ?> padding: var(--space-8); text-align: center; color: var(--text-tertiary);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto var(--space-4);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p>No items added to this kit yet</p>
                    <button type="button" class="btn btn-primary" onclick="addKitItem()" style="margin-top: var(--space-3);">Add First Item</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <!-- Pricing Options -->
        <div class="card" style="margin-bottom: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">Pricing Options</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="price_option" class="form-label">Price Option</label>
                    <select class="form-control form-select" id="price_option" name="price_option">
                        <option value="0" <?= isset($item_kit_info->price_option) && $item_kit_info->price_option == 0 ? 'selected' : '' ?>>Add All Items</option>
                        <option value="1" <?= isset($item_kit_info->price_option) && $item_kit_info->price_option == 1 ? 'selected' : '' ?>>Add Stocked Items Only</option>
                        <option value="2" <?= isset($item_kit_info->price_option) && $item_kit_info->price_option == 2 ? 'selected' : '' ?>>Use Kit Item Price</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="kit_discount" class="form-label">Kit Discount</label>
                    <input type="number" class="form-control" id="kit_discount" name="kit_discount" value="<?= esc($item_kit_info->kit_discount ?? 0) ?>" step="0.01" min="0">
                </div>
                
                <div class="form-group">
                    <label for="kit_discount_type" class="form-label">Discount Type</label>
                    <select class="form-control form-select" id="kit_discount_type" name="kit_discount_type">
                        <option value="0" <?= isset($item_kit_info->kit_discount_type) && $item_kit_info->kit_discount_type == 0 ? 'selected' : '' ?>>Percent (%)</option>
                        <option value="1" <?= isset($item_kit_info->kit_discount_type) && $item_kit_info->kit_discount_type == 1 ? 'selected' : '' ?>>Fixed Amount</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Print Options -->
        <div class="card" style="margin-bottom: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">Print Options</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="print_option" class="form-label">Print Option</label>
                    <select class="form-control form-select" id="print_option" name="print_option">
                        <option value="0" <?= isset($item_kit_info->print_option) && $item_kit_info->print_option == 0 ? 'selected' : '' ?>>Print All Items</option>
                        <option value="1" <?= isset($item_kit_info->print_option) && $item_kit_info->print_option == 1 ? 'selected' : '' ?>>Print Kit Item Only</option>
                        <option value="2" <?= isset($item_kit_info->print_option) && $item_kit_info->print_option == 2 ? 'selected' : '' ?>>Hide All</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?= $item_kit_info->item_kit_id ? 'Update' : 'Create' ?> Item Kit
                </button>
                
                <a href="<?= base_url('product_bundles') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<style>
.kit-item-row {
    padding: var(--space-4);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-3);
    background: var(--bg-surface);
}

.kit-item-row:hover {
    border-color: var(--primary-300);
}
</style>

<script>
let kitItemIndex = <?= count($item_kit_items ?? []) ?>;

function addKitItem() {
    if (window.shopsuiteApp) {
        const modalHtml = `
            <div style="padding: var(--space-4);">
                <div class="form-group">
                    <label class="form-label">Search Item</label>
                    <input type="text" class="form-control" id="item_search_modal" placeholder="Search for item...">
                </div>
                <div id="item_search_results" style="max-height: 300px; overflow-y: auto; margin-top: var(--space-3);"></div>
            </div>
        `;
        
        window.shopsuiteApp.showModal('Add Item to Kit', modalHtml);
        
        setTimeout(() => {
            const searchInput = document.getElementById('item_search_modal');
            if (searchInput) {
                searchInput.focus();
                let searchTimeout;
                
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value;
                    
                    if (query.length < 2) {
                        document.getElementById('item_search_results').innerHTML = '';
                        return;
                    }
                    
                    searchTimeout = setTimeout(() => {
                        fetch('<?= base_url("items/suggest_search") ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'term=' + encodeURIComponent(query)
                        })
                        .then(response => response.json())
                        .then(data => {
                            const resultsDiv = document.getElementById('item_search_results');
                            if (data.length === 0) {
                                resultsDiv.innerHTML = '<div style="padding: var(--space-4); text-align: center; color: var(--text-tertiary);">No items found</div>';
                            } else {
                                resultsDiv.innerHTML = data.map(item => `
                                    <div class="search-result-item" onclick="selectKitItem(${item.value}, '${item.label.replace(/'/g, "\\'")}', this)" style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer;">
                                        <div style="font-weight: var(--font-semibold);">${item.label}</div>
                                    </div>
                                `).join('');
                            }
                        });
                    }, 300);
                });
            }
        }, 100);
    }
}

function selectKitItem(itemId, itemName, element) {
    const container = document.getElementById('kit_items_container');
    const emptyState = document.getElementById('empty_state');
    
    const itemRow = document.createElement('div');
    itemRow.className = 'kit-item-row';
    itemRow.dataset.index = kitItemIndex++;
    
    itemRow.innerHTML = `
        <div class="grid grid-cols-12 gap-3" style="align-items: end;">
            <div class="col-span-6">
                <label class="form-label">Item</label>
                <input type="text" class="form-control" readonly value="${itemName}">
                <input type="hidden" name="item_id[]" value="${itemId}">
            </div>
            <div class="col-span-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity[]" value="1" min="1" step="0.01" required>
            </div>
            <div class="col-span-2">
                <label class="form-label">Sequence</label>
                <input type="number" class="form-control" name="kit_sequence[]" value="0" min="0">
            </div>
            <div class="col-span-1">
                <button type="button" class="btn btn-outline btn-sm" onclick="removeKitItem(this)" style="width: 100%;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(itemRow);
    emptyState.style.display = 'none';
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.hideModal();
    }
}

function removeKitItem(button) {
    const row = button.closest('.kit-item-row');
    row.remove();
    
    const container = document.getElementById('kit_items_container');
    const emptyState = document.getElementById('empty_state');
    
    if (container.children.length === 0) {
        emptyState.style.display = 'block';
    }
}

// Form submission
document.getElementById('item_kit_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const container = document.getElementById('kit_items_container');
    if (container.children.length === 0) {
        alert('Please add at least one item to the kit');
        return;
    }
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving item kit...');
    }
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }
        
        if (data.success) {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Success', data.message || 'Item kit saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("product_bundles") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save item kit', 'error');
            }
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
            window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
        }
        console.error('Error:', error);
    });
});
</script>

<?php echo view('layouts/modern_footer'); ?>
