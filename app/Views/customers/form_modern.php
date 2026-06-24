<?php
$title = (isset($person_info) && $person_info->person_id > 0) ? 'Edit Customer - ShopSuite' : 'Add Customer - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($person_info) && $person_info->person_id > 0;
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Customer' : 'Add New Customer' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('customers') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item">
            <a href="<?= base_url('home') ?>">Dashboard</a>
        </div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item">
            <a href="<?= base_url('customers') ?>">Customers</a>
        </div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></div>
    </div>
</div>

<!-- Form -->
<form id="customerForm" method="post" action="<?= base_url('customers/save/' . ($person_info->person_id ?? -1)) ?>">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Customer Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="first_name" class="form-label form-label-required">First Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="first_name" 
                                name="first_name"
                                value="<?= esc($person_info->first_name ?? '') ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name" class="form-label form-label-required">Last Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="last_name" 
                                name="last_name"
                                value="<?= esc($person_info->last_name ?? '') ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email"
                                    value="<?= esc($person_info->email ?? '') ?>"
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </span>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    id="phone_number" 
                                    name="phone_number"
                                    value="<?= esc($person_info->phone_number ?? '') ?>"
                                >
                            </div>
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="address_1" class="form-label">Address Line 1</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="address_1" 
                                name="address_1"
                                value="<?= esc($person_info->address_1 ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="address_2" class="form-label">Address Line 2</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="address_2" 
                                name="address_2"
                                value="<?= esc($person_info->address_2 ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="city" 
                                name="city"
                                value="<?= esc($person_info->city ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="form-label">State/Province</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="state" 
                                name="state"
                                value="<?= esc($person_info->state ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="zip" class="form-label">ZIP/Postal Code</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="zip" 
                                name="zip"
                                value="<?= esc($person_info->zip ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="country" class="form-label">Country</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="country" 
                                name="country"
                                value="<?= esc($person_info->country ?? '') ?>"
                            >
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="comments" class="form-label">Notes</label>
                            <textarea 
                                class="form-control" 
                                id="comments" 
                                name="comments"
                                rows="3"
                            ><?= esc($person_info->comments ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Information -->
        <div class="lg:col-span-1">
            <div class="card u-margin-bottom-space-6">
                <div class="card-header">
                    <h3 class="card-header-title">Account Details</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="account_number" 
                            name="account_number"
                            value="<?= esc($person_info->account_number ?? '') ?>"
                        >
                        <span class="form-help">Auto-generated if left blank</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="taxable" class="form-label">Tax Status</label>
                        <select class="form-control form-select" id="taxable" name="taxable">
                            <option value="1" <?= (isset($person_info) && $person_info->taxable == 1) ? 'selected' : '' ?>>Taxable</option>
                            <option value="0" <?= (isset($person_info) && $person_info->taxable == 0) ? 'selected' : '' ?>>Tax Exempt</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="discount" class="form-label">Discount %</label>
                        <div class="input-group">
                            <input 
                                type="number" 
                                class="form-control" 
                                id="discount" 
                                name="discount"
                                min="0"
                                max="100"
                                step="0.01"
                                value="<?= esc($person_info->discount_percent ?? '0') ?>"
                            >
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?= $is_edit ? 'Update Customer' : 'Save Customer' ?>
                    </button>
                    
                    <a href="<?= base_url('customers') ?>" class="btn btn-outline btn-block mt-space-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block u-margin-top-space-3" onclick="deleteCustomer()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Customer
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('customerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving customer...');
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
                window.shopsuiteApp.showToast('Success', 'Customer saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("customers") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save customer', 'error');
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

function deleteCustomer() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Customer',
            'Are you sure you want to delete this customer? This action cannot be undone.',
            function() {
                window.location.href = '<?= base_url("customers/delete/" . ($person_info->person_id ?? "")) ?>';
            }
        );
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
