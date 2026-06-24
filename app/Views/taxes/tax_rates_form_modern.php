<?php
/**
 * MODERN TAX RATE FORM - Add/Edit Tax Rate
 * @var int $tax_rate_id
 * @var array $tax_code_options
 * @var int $rate_tax_code_id
 * @var array $tax_category_options
 * @var int $rate_tax_category_id
 * @var array $tax_jurisdiction_options
 * @var int $rate_jurisdiction_id
 * @var float $tax_rate
 * @var array $rounding_options
 * @var int $tax_rounding_code
 */

$is_new = ($tax_rate_id == -1);
$title = ($is_new ? 'Add New' : 'Edit') . ' Tax Rate';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title"><?= $is_new ? 'Add New' : 'Edit' ?> Tax Rate</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('taxes') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Taxes</span>
        </a>
    </div>
</div>

<?= form_open("taxes/save/$tax_rate_id", ['id' => 'tax_rate_form', 'class' => 'modern-form']) ?>

<div class="u-display-grid_grid-template-columns-1fr">
    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">Tax Rate Information</h3>
        </div>
        <div class="card-body">
            <!-- Tax Code -->
            <div class="form-group">
                <label for="rate_tax_code_id" class="form-label form-label-required">Tax Code</label>
                <select name="rate_tax_code_id" id="rate_tax_code_id" class="form-control" required>
                    <?php foreach ($tax_code_options as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($value == $rate_tax_code_id) ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">Select the tax code for this rate</small>
            </div>

            <!-- Tax Category -->
            <div class="form-group">
                <label for="rate_tax_category_id" class="form-label form-label-required">Tax Category</label>
                <select name="rate_tax_category_id" id="rate_tax_category_id" class="form-control" required>
                    <?php foreach ($tax_category_options as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($value == $rate_tax_category_id) ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">Select the tax category</small>
            </div>

            <!-- Tax Jurisdiction -->
            <div class="form-group">
                <label for="rate_jurisdiction_id" class="form-label form-label-required">Tax Jurisdiction</label>
                <select name="rate_jurisdiction_id" id="rate_jurisdiction_id" class="form-control" required>
                    <?php foreach ($tax_jurisdiction_options as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($value == $rate_jurisdiction_id) ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">Select the jurisdiction</small>
            </div>

            <!-- Tax Rate -->
            <div class="form-group">
                <label for="tax_rate" class="form-label form-label-required">Tax Rate (%)</label>
                <div class="input-group">
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           max="100"
                           name="tax_rate" 
                           id="tax_rate" 
                           class="form-control" 
                           value="<?= esc($tax_rate) ?>" 
                           placeholder="0.00"
                           required>
                    <span class="input-group-text">%</span>
                </div>
                <small class="form-text">Enter the tax rate percentage (e.g., 5.00 for 5%)</small>
            </div>

            <!-- Tax Rounding -->
            <div class="form-group">
                <label for="tax_rounding_code" class="form-label">Rounding Method</label>
                <select name="tax_rounding_code" id="tax_rounding_code" class="form-control">
                    <?php foreach ($rounding_options as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($value == $tax_rounding_code) ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">Select how tax amounts should be rounded</small>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Actions Card -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-check-circle"></i>
                    <span><?= $is_new ? 'Create' : 'Update' ?> Tax Rate</span>
                </button>
                
                <a href="<?= base_url('taxes') ?>" class="btn btn-secondary btn-block mt-space-3">
                    <i class="bi bi-x-circle"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </div>

        <!-- Help Card -->
        <div class="card u-margin-top-space-4">
            <div class="card-header">
                <h3 class="card-header-title">
                    <i class="bi bi-info-circle"></i>
                    Help
                </h3>
            </div>
            <div class="card-body">
                <div class="u-font-size-text-sm_color-text-secondary-2">
                    <p class="u-margin-bottom-space-3"><strong>Tax Code:</strong> The general tax code identifier</p>
                    <p class="u-margin-bottom-space-3"><strong>Tax Category:</strong> The category this rate applies to</p>
                    <p class="u-margin-bottom-space-3"><strong>Jurisdiction:</strong> Geographic area this rate applies to</p>
                    <p class="u-margin-bottom-0"><strong>Tax Rate:</strong> The percentage to be applied</p>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="card u-margin-top-space-4">
            <div class="card-header">
                <h3 class="card-header-title">
                    <i class="bi bi-calculator"></i>
                    Quick Preview
                </h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="u-font-size-text-xs_color-text-tertiary_">
                        Tax on $100.00
                    </div>
                    <div class="u-font-size-text-3xl_font-weight-font-bo-1" id="tax_preview">
                        $0.00
                    </div>
                    <div class="u-font-size-text-sm_color-text-secondary-3" id="total_preview">
                        Total: $100.00
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>



<script>
// Form submission
document.getElementById('tax_rate_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    console.log('Submitting tax rate form...');
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving tax rate...');
    }
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(text => {
        console.log('Response:', text);
        try {
            const data = JSON.parse(text);
            
            if (window.shopsuiteApp) {
                window.shopsuiteApp.hideLoading();
            }
            
            if (data.success) {
                if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
                    window.shopsuiteApp.showToast('Success', data.message || 'Tax rate saved successfully', 'success');
                } else {
                    alert(data.message || 'Tax rate saved successfully');
                }
                setTimeout(() => {
                    window.location.href = '<?= base_url("taxes") ?>';
                }, 1000);
            } else {
                if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
                    window.shopsuiteApp.showToast('Error', data.message || 'Failed to save tax rate', 'error');
                } else {
                    alert('Error: ' + (data.message || 'Failed to save tax rate'));
                }
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            if (window.shopsuiteApp) {
                window.shopsuiteApp.hideLoading();
            }
            alert('Error: Invalid response from server. Check console for details.');
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }
        if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
            window.shopsuiteApp.showToast('Error', 'An error occurred: ' + error.message, 'error');
        } else {
            alert('Error: ' + error.message);
        }
        console.error('Fetch error:', error);
    });
});

// Update tax preview
function updateTaxPreview() {
    const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
    const baseAmount = 100;
    const taxAmount = (baseAmount * taxRate / 100);
    const total = baseAmount + taxAmount;
    
    document.getElementById('tax_preview').textContent = '$' + taxAmount.toFixed(2);
    document.getElementById('total_preview').textContent = 'Total: $' + total.toFixed(2);
}

// Listen for tax rate changes
document.getElementById('tax_rate').addEventListener('input', updateTaxPreview);

// Initialize preview
updateTaxPreview();
</script>

<?= view('layouts/modern_footer') ?>
