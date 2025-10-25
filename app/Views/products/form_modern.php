<?php
$title = (isset($item_info) && $item_info->item_id > 0) ? 'Edit Product - ShopSuite' : 'Add Product - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($item_info) && $item_info->item_id > 0;
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Product' : 'Add New Product' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('products') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('products') ?>">Products</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></div>
    </div>
</div>

<form id="itemForm" method="post" action="<?= base_url('products/save/' . ($item_info->item_id ?? -1)) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card" style="margin-bottom: var(--space-6);">
                <div class="card-header">
                    <h3 class="card-header-title">Basic Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group sm:col-span-2">
                            <label for="name" class="form-label form-label-required">Item Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= esc($item_info->name ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="item_number" class="form-label">SKU/Barcode</label>
                            <input type="text" class="form-control" id="item_number" name="item_number" value="<?= esc($item_info->item_number ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?= esc($item_info->category ?? '') ?>">
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= esc($item_info->description ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Pricing & Inventory</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="cost_price" class="form-label">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="cost_price" name="cost_price" step="0.01" min="0" value="<?= esc($item_info->cost_price ?? '0.00') ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="unit_price" class="form-label form-label-required">Unit Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" min="0" value="<?= esc($item_info->unit_price ?? '0.00') ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" step="1" min="0" value="<?= esc($item_info->quantity ?? '0') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="reorder_level" class="form-label">Reorder Level</label>
                            <input type="number" class="form-control" id="reorder_level" name="reorder_level" step="1" min="0" value="<?= esc($item_info->reorder_level ?? '0') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="card" style="margin-bottom: var(--space-6);">
                <div class="card-header">
                    <h3 class="card-header-title">Item Image</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center;">
                        <?php if (isset($image_path) && !empty($image_path)): ?>
                            <img src="<?= esc($image_path) ?>" alt="Item" style="max-width: 100%; border-radius: var(--radius-lg); margin-bottom: var(--space-4);">
                        <?php else: ?>
                            <div style="width: 100%; height: 200px; background-color: var(--bg-secondary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-4);">
                                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--text-tertiary);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" class="form-control" id="items_image" name="items_image" accept="image/*">
                        <span class="form-help">Max size: 2MB</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?= $is_edit ? 'Update Item' : 'Save Item' ?>
                    </button>
                    
                    <a href="<?= base_url('products') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteItem()" style="margin-top: var(--space-3);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Item
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('itemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving item...');
    }
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }
        
        if (data.success) {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Success', 'Item saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("products") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save item', 'error');
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

function deleteItem() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Item',
            'Are you sure you want to delete this item? This action cannot be undone.',
            function() {
                window.location.href = '<?= base_url("items/delete/" . ($item_info->item_id ?? "")) ?>';
            }
        );
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
