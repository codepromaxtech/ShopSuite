<?php
$title = (isset($giftcard_id) && $giftcard_id > 0) ? 'Edit Gift Card - ShopSuite' : 'Add Gift Card - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($giftcard_id) && $giftcard_id > 0;
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Gift Card' : 'Add New Gift Card' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('giftcards') ?>" class="btn btn-outline">
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
        <div class="breadcrumb-item"><a href="<?= base_url('giftcards') ?>">Gift Cards</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></div>
    </div>
</div>

<form id="giftcardForm" method="post" action="<?= base_url('giftcards/save/' . ($giftcard_id ?? -1)) ?>">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Gift Card Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="giftcard_number" class="form-label form-label-required">Card Number</label>
                            <input type="text" class="form-control" id="giftcard_number" name="giftcard_number" value="<?= esc($giftcard_number ?? '') ?>" required style="font-family: var(--font-mono);">
                            <?php if (!$is_edit): ?>
                                <span class="form-help">Leave blank to auto-generate</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="value" class="form-label form-label-required">Value</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="value" name="value" value="<?= esc($giftcard_value ?? '0.00') ?>" step="0.01" min="0" required>
                            </div>
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="person_id" class="form-label">Assign to Customer</label>
                            <select class="form-control form-select" id="person_id" name="person_id">
                                <option value="">No Customer</option>
                                <?php if (isset($selected_person_id) && $selected_person_id > 0): ?>
                                    <option value="<?= $selected_person_id ?>" selected><?= esc($selected_person_name ?? '') ?></option>
                                <?php endif; ?>
                            </select>
                            <span class="form-help">Optional: Link this gift card to a specific customer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?= $is_edit ? 'Update Gift Card' : 'Save Gift Card' ?>
                    </button>
                    
                    <a href="<?= base_url('giftcards') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteGiftcard()" style="margin-top: var(--space-3);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Gift Card
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('giftcardForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving gift card...');
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
                window.shopsuiteApp.showToast('Success', 'Gift card saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("giftcards") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save gift card', 'error');
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

function deleteGiftcard() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Gift Card',
            'Are you sure you want to delete this gift card? This action cannot be undone.',
            function() {
                fetch(`<?= base_url("giftcards/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [<?= $giftcard_id ?? 0 ?>] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Success', 'Gift card deleted successfully', 'success');
                        }
                        setTimeout(() => {
                            window.location.href = '<?= base_url("giftcards") ?>';
                        }, 1000);
                    } else {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete gift card', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (window.shopsuiteApp) {
                        window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
                    }
                });
            }
        );
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
