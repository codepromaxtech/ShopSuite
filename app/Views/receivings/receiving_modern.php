<?php
$title = 'New Receiving - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            <div>
                <h1>Receiving</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('receivings/manage') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                View History
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('receivings/manage') ?>">Receivings</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">New Receiving</div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<?php if (isset($warning)): ?>
    <div class="alert alert-warning"><?= esc($warning) ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= esc($success) ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card u-margin-bottom-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Receiving Options</h3>
            </div>
            <div class="card-body">
                <?= form_open("receivings/changeMode", ['id' => 'mode_form']) ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="mode" class="form-label">Mode</label>
                        <?= form_dropdown('mode', $modes, $mode, ['id' => 'mode', 'class' => 'form-control form-select', 'onchange' => "$('#mode_form').submit();"]) ?>
                    </div>
                    
                    <?php if ($show_stock_locations): ?>
                        <div class="form-group">
                            <label for="stock_source" class="form-label">Stock Source</label>
                            <?= form_dropdown('stock_source', $stock_locations, $stock_source, ['id' => 'stock_source', 'class' => 'form-control form-select', 'onchange' => "$('#mode_form').submit();"]) ?>
                        </div>
                        
                        <?php if ($mode == 'requisition'): ?>
                            <div class="form-group">
                                <label for="stock_destination" class="form-label">Stock Destination</label>
                                <?= form_dropdown('stock_destination', $stock_locations, $stock_destination, ['id' => 'stock_destination', 'class' => 'form-control form-select', 'onchange' => "$('#mode_form').submit();"]) ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        
        <div class="card u-margin-bottom-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Add Items</h3>
            </div>
            <div class="card-body">
                <?= form_open("receivings/add", ['id' => 'add_item_form']) ?>
                <div class="form-group">
                    <label for="item" class="form-label">
                        <?php if ($mode == 'receive' || $mode == 'requisition'): ?>
                            Find or Scan Item
                        <?php else: ?>
                            Find or Scan Item or Receipt
                        <?php endif; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <?= form_input(['name' => 'item', 'id' => 'item', 'class' => 'form-control', 'autofocus' => 'autofocus']) ?>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-header-title">Items in Receiving</h3>
            </div>
            <div class="card-body">
                <?php if (empty($cart)): ?>
                    <div class="u-text-align-center_padding-space-8space">
                        <svg class="u-margin-0autospace-4" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="u-font-size-text-base_margin-0">No items in this receiving</p>
                        <p class="u-font-size-text-sm_margin-top-space-2">Scan or search for items to add them</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th class="u-width-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $line => $item): ?>
                                    <tr>
                                        <td>
                                            <div class="u-font-weight-font-medium"><?= esc($item['name']) ?></div>
                                            <?php if (!empty($item['description'])): ?>
                                                <div class="u-font-size-text-sm_color-text-secondary"><?= esc($item['description']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($item['quantity']) ?></td>
                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                        <td><?= esc($item['discount']) ?>%</td>
                                        <td class="u-font-weight-font-semibold">$<?= number_format($item['total'], 2) ?></td>
                                        <td>
                                            <div class="flex gap-2">
                                                <button type="button" class="btn btn-sm btn-ghost" title="Remove" onclick="removeReceivingItem(<?= $line ?>)">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="card u-margin-bottom-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Supplier</h3>
            </div>
            <div class="card-body">
                <?php if (isset($supplier) && $supplier > 0): ?>
                    <div class="u-margin-bottom-space-4">
                        <div class="u-font-weight-font-semibold_margin-botto"><?= esc($company_name ?? '') ?></div>
                        <?php if (isset($supplier_address)): ?>
                            <div class="u-font-size-text-sm_color-text-secondary"><?= esc($supplier_address) ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-outline btn-sm btn-block" onclick="removeReceivingSupplier()">Change Supplier</button>
                <?php else: ?>
                    <?= form_open("receivings/selectSupplier", ['id' => 'supplier_form']) ?>
                    <div class="form-group">
                        <label for="supplier" class="form-label">Select Supplier</label>
                        <select name="supplier" id="supplier" class="form-control form-select" onchange="$('#supplier_form').submit();">
                            <option value="">No Supplier</option>
                        </select>
                    </div>
                    <?= form_close() ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card u-margin-bottom-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Total</h3>
            </div>
            <div class="card-body">
                <div class="u-font-size-text-3xl_font-weight-font-bo-3">
                    $<?= number_format($total ?? 0, 2) ?>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <?php if (!empty($cart)): ?>
                    <?= form_open("receivings/complete", ['id' => 'complete_form']) ?>
                    <button type="submit" class="btn btn-success btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Complete Receiving
                    </button>
                    <?= form_close() ?>
                    
                    <a href="<?= base_url('receivings/cancelReceiving') ?>" class="btn btn-outline btn-block mt-space-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('receivings/manage') ?>" class="btn btn-outline btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function removeReceivingItem(line) {
    window.shopsuiteApp.postAction('<?= base_url("receivings/deleteItem") ?>/' + line)
        .then(() => window.location.reload())
        .catch(err => console.error('Error removing item:', err));
}

function removeReceivingSupplier() {
    window.shopsuiteApp.postAction('<?= base_url("receivings/removeSupplier") ?>')
        .then(() => window.location.reload())
        .catch(err => console.error('Error removing supplier:', err));
}

// Auto-focus the item search input
document.addEventListener('DOMContentLoaded', function() {
    const itemInput = document.getElementById('item');
    if (itemInput) {
        itemInput.focus();
    }
    
    // Auto-submit form when item is scanned/entered
    itemInput?.addEventListener('change', function() {
        document.getElementById('add_item_form').submit();
    });
});
</script>

<?php echo view('layouts/modern_footer'); ?>
