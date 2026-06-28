<?php
/**
 * @var array $receiving_info
 * @var string $selected_supplier_name
 * @var int|null $selected_supplier_id
 * @var array $employees
 * @var string $controller_name
 * @var array $config
 */
$title = 'Edit Receiving RECV ' . (int) $receiving_info['receiving_id'] . ' - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <div>
                <h1>Edit Receiving #<?= (int) $receiving_info['receiving_id'] ?></h1>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?= base_url('receivings/receipt/' . $receiving_info['receiving_id']) ?>" class="btn btn-outline" target="_blank" rel="noopener">
                View Receipt
            </a>
            <a href="<?= base_url('receivings') ?>" class="btn btn-outline">
                Back to List
            </a>
        </div>
    </div>
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('receivings') ?>">Receivings</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Edit</div>
    </div>
</div>

<form id="receivingsEditForm" method="post" action="<?= base_url('receivings/save/' . $receiving_info['receiving_id']) ?>">
    <?= csrf_field() ?>

    <div class="card u-margin-bottom-space-6">
        <div class="card-header">
            <h3 class="card-header-title">Receiving Details</h3>
        </div>
        <div class="card-body">
            <p class="form-help u-margin-bottom-space-4"><?= lang('Common.fields_required_message') ?></p>
            <div id="formErrors" class="alert alert-danger hidden" role="alert"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-group sm:col-span-2">
                    <label for="date" class="form-label"><?= lang('Receivings.date') ?></label>
                    <input type="text" class="form-control" id="date" name="date" value="<?= esc(to_datetime(strtotime($receiving_info['receiving_time']))) ?>" readonly>
                </div>

                <div class="form-group sm:col-span-2 autocomplete-container">
                    <label for="supplier_name" class="form-label"><?= lang('Receivings.supplier') ?></label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?= esc($selected_supplier_name) ?>" autocomplete="off">
                    <input type="hidden" id="supplier_id" name="supplier_id" value="<?= esc($selected_supplier_id ?? '') ?>">
                    <div id="supplierAutocomplete" class="autocomplete-results"></div>
                </div>

                <div class="form-group">
                    <label for="reference" class="form-label"><?= lang('Receivings.reference') ?></label>
                    <input type="text" class="form-control" id="reference" name="reference" value="<?= esc($receiving_info['reference'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="employee_id" class="form-label"><?= lang('Receivings.employee') ?></label>
                    <select class="form-control form-select" id="employee_id" name="employee_id">
                        <?php foreach ($employees as $employee_id => $employee_name): ?>
                            <option value="<?= (int) $employee_id ?>" <?= (int) $receiving_info['employee_id'] === (int) $employee_id ? 'selected' : '' ?>>
                                <?= esc($employee_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group sm:col-span-2">
                    <label for="comment" class="form-label"><?= lang('Receivings.comments') ?></label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"><?= esc($receiving_info['comment'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="flex gap-3 justify-end">
                <a href="<?= base_url('receivings') ?>" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupSupplierAutocomplete();
    document.getElementById('receivingsEditForm').addEventListener('submit', submitReceivingForm);
});

function setupSupplierAutocomplete() {
    const input = document.getElementById('supplier_name');
    const hidden = document.getElementById('supplier_id');
    const dropdown = document.getElementById('supplierAutocomplete');
    let debounceTimer;

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const term = input.value.trim();
        if (term.length < 1) {
            dropdown.classList.remove('active');
            return;
        }

        debounceTimer = setTimeout(function() {
            fetch(`<?= base_url('suppliers/suggest') ?>?term=${encodeURIComponent(term)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    dropdown.classList.remove('active');
                    return;
                }

                dropdown.innerHTML = data.map(item => `
                    <div class="autocomplete-item" data-value="${item.value}">${item.label}</div>
                `).join('');
                dropdown.classList.add('active');

                dropdown.querySelectorAll('.autocomplete-item').forEach(el => {
                    el.addEventListener('click', function() {
                        hidden.value = el.dataset.value;
                        input.value = el.textContent.trim();
                        dropdown.classList.remove('active');
                    });
                });
            })
            .catch(() => { dropdown.classList.remove('active'); });
        }, 200);
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.autocomplete-container')) {
            dropdown.classList.remove('active');
        }
    });
}

function submitReceivingForm(event) {
    event.preventDefault();
    const form = event.target;

    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading();
    }

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }

        if (data.success) {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Success', data.message || 'Receiving updated', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url('receivings') ?>';
            }, 800);
        } else if (window.shopsuiteApp) {
            window.shopsuiteApp.showToast('Error', data.message || 'Update failed', 'error');
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
            window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
        }
        console.error(error);
    });
}
</script>

<?= view('layouts/modern_footer') ?>
