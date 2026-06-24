<?php
$title = (isset($expenses_info) && $expenses_info->expense_id > 0) ? 'Edit Expense - ShopSuite' : 'Add Expense - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($expenses_info) && $expenses_info->expense_id > 0;
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Expense' : 'Add New Expense' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('expenses') ?>" class="btn btn-outline">
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
        <div class="breadcrumb-item"><a href="<?= base_url('expenses') ?>">Expenses</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></div>
    </div>
</div>

<form id="expenseForm" method="post" action="<?= base_url('expenses/save/' . ($expenses_info->expense_id ?? -1)) ?>">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Expense Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="date" class="form-label form-label-required">Date</label>
                            <input type="datetime-local" class="form-control" id="date" name="date" value="<?= isset($expenses_info->date) ? date('Y-m-d\TH:i', strtotime($expenses_info->date)) : date('Y-m-d\TH:i') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount" class="form-label form-label-required">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?= esc($expenses_info->amount ?? '0.00') ?>" step="0.01" min="0" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id" class="form-label form-label-required">Category</label>
                            <select class="form-control form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php if (isset($expense_categories)): ?>
                                    <?php foreach($expense_categories as $id => $name): ?>
                                        <option value="<?= esc($id) ?>" <?= (isset($expenses_info) && $expenses_info->category_id == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-control form-select" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                <?php if (isset($employees)): ?>
                                    <?php foreach($employees as $id => $name): ?>
                                        <option value="<?= esc($id) ?>" <?= (isset($expenses_info) && $expenses_info->employee_id == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select class="form-control form-select" id="supplier_id" name="supplier_id">
                                <option value="">No Supplier</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tax" class="form-label">Tax</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="tax" name="tax" value="<?= esc($expenses_info->tax ?? '0.00') ?>" step="0.01" min="0">
                            </div>
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="description" class="form-label form-label-required">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= esc($expenses_info->description ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="payment_type" class="form-label">Payment Type</label>
                            <select class="form-control form-select" id="payment_type" name="payment_type">
                                <?php if (isset($payment_options)): ?>
                                    <?php foreach($payment_options as $key => $value): ?>
                                        <option value="<?= esc($key) ?>" <?= (isset($expenses_info) && $expenses_info->payment_type == $key) ? 'selected' : '' ?>><?= esc($value) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
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
                        <?= $is_edit ? 'Update Expense' : 'Save Expense' ?>
                    </button>
                    
                    <a href="<?= base_url('expenses') ?>" class="btn btn-outline btn-block mt-space-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block u-margin-top-space-3" onclick="deleteExpense()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Expense
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('expenseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving expense...');
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
                window.shopsuiteApp.showToast('Success', 'Expense saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("expenses") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save expense', 'error');
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

function deleteExpense() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Expense',
            'Are you sure you want to delete this expense? This action cannot be undone.',
            function() {
                fetch(`<?= base_url("expenses/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [<?= $expenses_info->expense_id ?? 0 ?>] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Success', 'Expense deleted successfully', 'success');
                        }
                        setTimeout(() => {
                            window.location.href = '<?= base_url("expenses") ?>';
                        }, 1000);
                    } else {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete expense', 'error');
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
