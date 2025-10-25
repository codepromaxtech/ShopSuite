<?php
$title = (isset($cash_ups_info) && $cash_ups_info->cashup_id > 0) ? 'Edit Cash Up - ShopSuite' : 'New Cash Up - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($cash_ups_info) && $cash_ups_info->cashup_id > 0;
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Cash Up' : 'New Cash Up' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('cashups') ?>" class="btn btn-outline">
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
        <div class="breadcrumb-item"><a href="<?= base_url('cashups') ?>">Cash Ups</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'New' ?></div>
    </div>
</div>

<form id="cashupForm" method="post" action="<?= base_url('cashups/save/' . ($cash_ups_info->cashup_id ?? -1)) ?>">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card" style="margin-bottom: var(--space-6);">
                <div class="card-header">
                    <h3 class="card-header-title">Register Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="open_date" class="form-label form-label-required">Opening Date/Time</label>
                            <input type="datetime-local" class="form-control" id="open_date" name="open_date" value="<?= isset($cash_ups_info->open_date) ? date('Y-m-d\TH:i', strtotime($cash_ups_info->open_date)) : date('Y-m-d\TH:i') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="close_date" class="form-label">Closing Date/Time</label>
                            <input type="datetime-local" class="form-control" id="close_date" name="close_date" value="<?= isset($cash_ups_info->close_date) ? date('Y-m-d\TH:i', strtotime($cash_ups_info->close_date)) : '' ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="employee_id" class="form-label form-label-required">Employee</label>
                            <select class="form-control form-select" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                <?php if (isset($employees)): ?>
                                    <?php foreach($employees as $id => $name): ?>
                                        <option value="<?= esc($id) ?>" <?= (isset($cash_ups_info) && $cash_ups_info->employee_id == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Cash Amounts</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="open_amount_cash" class="form-label form-label-required">Opening Cash</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="open_amount_cash" name="open_amount_cash" value="<?= esc($cash_ups_info->open_amount_cash ?? '0.00') ?>" step="0.01" min="0" required onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="transfer_amount_cash" class="form-label">Transfer Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="transfer_amount_cash" name="transfer_amount_cash" value="<?= esc($cash_ups_info->transfer_amount_cash ?? '0.00') ?>" step="0.01" onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="closed_amount_cash" class="form-label">Closing Cash</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="closed_amount_cash" name="closed_amount_cash" value="<?= esc($cash_ups_info->closed_amount_cash ?? '0.00') ?>" step="0.01" min="0" onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="closed_amount_due" class="form-label">Due Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="closed_amount_due" name="closed_amount_due" value="<?= esc($cash_ups_info->closed_amount_due ?? '0.00') ?>" step="0.01" min="0" onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="closed_amount_card" class="form-label">Card Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="closed_amount_card" name="closed_amount_card" value="<?= esc($cash_ups_info->closed_amount_card ?? '0.00') ?>" step="0.01" min="0" onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="closed_amount_check" class="form-label">Check Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="closed_amount_check" name="closed_amount_check" value="<?= esc($cash_ups_info->closed_amount_check ?? '0.00') ?>" step="0.01" min="0" onchange="calculateTotal()">
                            </div>
                        </div>
                        
                        <div class="form-group sm:col-span-2">
                            <label for="note" class="form-label">Notes</label>
                            <textarea class="form-control" id="note" name="note" rows="3"><?= esc($cash_ups_info->note ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="card" style="margin-bottom: var(--space-6);">
                <div class="card-header">
                    <h3 class="card-header-title">Total</h3>
                </div>
                <div class="card-body">
                    <div id="cashupTotal" style="font-size: var(--text-3xl); font-weight: var(--font-bold); text-align: center;">
                        $<?= number_format($cash_ups_info->closed_amount_total ?? 0, 2) ?>
                    </div>
                    <p style="font-size: var(--text-sm); color: var(--text-secondary); text-align: center; margin-top: var(--space-2);">
                        Net Difference
                    </p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?= $is_edit ? 'Update Cash Up' : 'Save Cash Up' ?>
                    </button>
                    
                    <a href="<?= base_url('cashups') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteCashup()" style="margin-top: var(--space-3);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Cash Up
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function calculateTotal() {
    const openAmount = parseFloat(document.getElementById('open_amount_cash').value) || 0;
    const transferAmount = parseFloat(document.getElementById('transfer_amount_cash').value) || 0;
    const closedCash = parseFloat(document.getElementById('closed_amount_cash').value) || 0;
    const closedDue = parseFloat(document.getElementById('closed_amount_due').value) || 0;
    const closedCard = parseFloat(document.getElementById('closed_amount_card').value) || 0;
    const closedCheck = parseFloat(document.getElementById('closed_amount_check').value) || 0;
    
    const total = (closedCash - openAmount - transferAmount + closedDue + closedCard + closedCheck);
    
    document.getElementById('cashupTotal').textContent = '$' + total.toFixed(2);
    
    // Color based on positive/negative
    if (total >= 0) {
        document.getElementById('cashupTotal').style.color = 'var(--success-600)';
    } else {
        document.getElementById('cashupTotal').style.color = 'var(--danger-600)';
    }
}

document.getElementById('cashupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving cash up...');
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
                window.shopsuiteApp.showToast('Success', 'Cash up saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("cashups") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save cash up', 'error');
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

function deleteCashup() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Cash Up',
            'Are you sure you want to delete this cash up record? This action cannot be undone.',
            function() {
                fetch(`<?= base_url("cashups/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [<?= $cash_ups_info->cashup_id ?? 0 ?>] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Success', 'Cash up deleted successfully', 'success');
                        }
                        setTimeout(() => {
                            window.location.href = '<?= base_url("cashups") ?>';
                        }, 1000);
                    } else {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete cash up', 'error');
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

// Calculate initial total
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>

<?php echo view('layouts/modern_footer'); ?>
