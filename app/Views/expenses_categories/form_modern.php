<?php
/**
 * MODERN EXPENSE CATEGORY FORM - Create/Edit Expense Category
 * @var object $category_info
 */

$is_new = empty($category_info->expense_category_id);

$title = ($is_new ? 'Add New' : 'Edit') . ' Expense Category - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            <div>
                <h1><?= $is_new ? 'Add New' : 'Edit' ?> Expense Category</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('expenses_categories') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('expenses_categories') ?>">Expense Categories</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_new ? 'Add' : 'Edit' ?></div>
    </div>
</div>

<?= form_open("expenses_categories/save/{$category_info->expense_category_id}", ['id' => 'expense_category_form', 'class' => 'form-modern']) ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Category Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-header-title">Category Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="category_name" class="form-label form-label-required">Category Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="category_name" 
                           name="category_name" 
                           value="<?= esc($category_info->category_name ?? '') ?>"
                           required
                           placeholder="e.g., Office Supplies, Travel, Utilities">
                    <small class="form-text">A descriptive name for this expense category</small>
                </div>
                
                <div class="form-group">
                    <label for="category_description" class="form-label">Description</label>
                    <textarea class="form-control" 
                              id="category_description" 
                              name="category_description" 
                              rows="4"
                              placeholder="Describe what types of expenses belong in this category..."><?= esc($category_info->category_description ?? '') ?></textarea>
                    <small class="form-text">Optional: Add details about this category</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <!-- Actions -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?= $is_new ? 'Create' : 'Update' ?> Category
                </button>
                
                <a href="<?= base_url('expenses_categories') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="card" style="margin-top: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">About Categories</h3>
            </div>
            <div class="card-body">
                <p style="font-size: var(--text-sm); color: var(--text-secondary); margin: 0;">
                    Expense categories help you organize and track different types of business expenses. 
                    Use meaningful names that clearly identify the type of expense.
                </p>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<script>
// Form submission
document.getElementById('expense_category_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving category...');
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
                window.shopsuiteApp.showToast('Success', data.message || 'Category saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("expenses_categories") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save category', 'error');
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
