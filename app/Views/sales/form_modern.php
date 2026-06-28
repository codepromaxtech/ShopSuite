<?php
/**
 * @var array $sale_info
 * @var bool $balance_due
 * @var array $new_payment_options
 * @var string $payment_type_new
 * @var float $payment_amount_new
 * @var array $payments
 * @var array $payment_options
 * @var string $selected_customer_name
 * @var int|null $selected_customer_id
 * @var string $selected_employee_name
 * @var int $selected_employee_id
 * @var string $controller_name
 * @var array $config
 */
$title = 'Edit Sale POS ' . (int) $sale_info['sale_id'] . ' - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <div>
                <h1>Edit Sale #<?= (int) $sale_info['sale_id'] ?></h1>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?= base_url('sales/receipt/' . $sale_info['sale_id']) ?>" class="btn btn-outline" target="_blank" rel="noopener">
                View Receipt
            </a>
            <a href="<?= base_url('sales') ?>" class="btn btn-outline">
                Back to List
            </a>
        </div>
    </div>
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('sales') ?>">Sales</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Edit</div>
    </div>
</div>

<form id="salesEditForm" method="post" action="<?= base_url('sales/save/' . $sale_info['sale_id']) ?>">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card u-margin-bottom-space-6">
                <div class="card-header">
                    <h3 class="card-header-title">Sale Information</h3>
                </div>
                <div class="card-body">
                    <p class="form-help u-margin-bottom-space-4"><?= lang('Common.fields_required_message') ?></p>
                    <div id="formErrors" class="alert alert-danger hidden" role="alert"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label"><?= lang('Sales.receipt_number') ?></label>
                            <div>
                                <a href="<?= base_url('sales/receipt/' . $sale_info['sale_id']) ?>" target="_blank" rel="noopener" class="text-link">
                                    POS <?= (int) $sale_info['sale_id'] ?>
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date" class="form-label"><?= lang('Sales.date') ?></label>
                            <input type="text" class="form-control" id="date" name="date" value="<?= esc(to_datetime(strtotime($sale_info['sale_time']))) ?>">
                        </div>

                        <?php if ($config['invoice_enable']) { ?>
                        <div class="form-group sm:col-span-2">
                            <label for="invoice_number" class="form-label"><?= lang('Sales.invoice_number') ?></label>
                            <div class="flex gap-3 items-center flex-wrap">
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= esc($sale_info['invoice_number'] ?? '') ?>">
                                <?php if (!empty($sale_info['invoice_number']) && isset($sale_info['customer_id']) && !empty($sale_info['email'])): ?>
                                    <button type="button" class="btn btn-outline btn-sm" id="sendInvoiceBtn"><?= lang('Sales.send_invoice') ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="form-group sm:col-span-2 autocomplete-container">
                            <label for="customer_name" class="form-label"><?= lang('Sales.customer') ?></label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= esc($selected_customer_name) ?>" autocomplete="off">
                            <input type="hidden" id="customer_id" name="customer_id" value="<?= esc($selected_customer_id ?? '') ?>">
                            <div id="customerAutocomplete" class="autocomplete-results"></div>
                        </div>

                        <div class="form-group sm:col-span-2 autocomplete-container">
                            <label for="employee_name" class="form-label"><?= lang('Sales.employee') ?></label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?= esc($selected_employee_name) ?>" autocomplete="off">
                            <input type="hidden" id="employee_id" name="employee_id" value="<?= esc($selected_employee_id) ?>">
                            <div id="employeeAutocomplete" class="autocomplete-results"></div>
                        </div>

                        <div class="form-group sm:col-span-2">
                            <label for="comment" class="form-label"><?= lang('Sales.comment') ?></label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"><?= esc($sale_info['comment'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title"><?= lang('Sales.payment') ?></h3>
                </div>
                <div class="card-body">
                    <?php if ($balance_due) { ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 u-margin-bottom-space-4">
                        <div class="form-group">
                            <label for="payment_types_new" class="form-label"><?= lang('Sales.payment') ?> (New)</label>
                            <select class="form-control form-select" id="payment_types_new" name="payment_type_new">
                                <?php foreach ($new_payment_options as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= $payment_type_new === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_amount_new" class="form-label"><?= lang('Sales.amount') ?></label>
                            <div class="input-group">
                                <?php if (!is_right_side_currency_symbol()): ?>
                                    <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                <?php endif; ?>
                                <input type="text" class="form-control" id="payment_amount_new" name="payment_amount_new" value="<?= esc($payment_amount_new) ?>">
                                <?php if (is_right_side_currency_symbol()): ?>
                                    <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php
                    $i = 0;
                    foreach ($payments as $row):
                    ?>
                    <div class="payment-edit-block u-margin-bottom-space-4">
                        <input type="hidden" name="payment_id_<?= $i ?>" value="<?= (int) $row->payment_id ?>">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="payment_types_<?= $i ?>" class="form-label"><?= lang('Sales.payment') ?> #<?= $i + 1 ?></label>
                                <?php if (!empty(strstr($row->payment_type, lang('Sales.giftcard')))): ?>
                                    <input type="text" class="form-control" name="payment_type_<?= $i ?>" value="<?= esc($row->payment_type) ?>" readonly>
                                <?php else: ?>
                                    <select class="form-control form-select" id="payment_types_<?= $i ?>" name="payment_type_<?= $i ?>">
                                        <?php foreach ($payment_options as $value => $label): ?>
                                            <option value="<?= esc($value) ?>" <?= $row->payment_type === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="payment_amount_<?= $i ?>" class="form-label"><?= lang('Sales.amount') ?></label>
                                <div class="input-group">
                                    <?php if (!is_right_side_currency_symbol()): ?>
                                        <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                    <?php endif; ?>
                                    <input type="text" class="form-control" name="payment_amount_<?= $i ?>" value="<?= esc($row->payment_amount) ?>" readonly>
                                    <?php if (is_right_side_currency_symbol()): ?>
                                        <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="refund_types_<?= $i ?>" class="form-label"><?= lang('Sales.refund') ?></label>
                                <?php if (!empty(strstr($row->payment_type, lang('Sales.giftcard')))): ?>
                                    <input type="text" class="form-control" name="refund_type_<?= $i ?>" value="<?= esc(lang('Sales.cash')) ?>" readonly>
                                <?php else: ?>
                                    <select class="form-control form-select" id="refund_types_<?= $i ?>" name="refund_type_<?= $i ?>">
                                        <?php foreach ($payment_options as $value => $label): ?>
                                            <option value="<?= esc($value) ?>" <?= lang('Sales.cash') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="refund_amount_<?= $i ?>" class="form-label"><?= lang('Sales.refund') ?> <?= lang('Sales.amount') ?></label>
                                <div class="input-group">
                                    <?php if (!is_right_side_currency_symbol()): ?>
                                        <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                    <?php endif; ?>
                                    <input type="text" class="form-control" name="refund_amount_<?= $i ?>" value="<?= esc($row->cash_refund) ?>" readonly>
                                    <?php if (is_right_side_currency_symbol()): ?>
                                        <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    ++$i;
                    endforeach;
                    ?>
                    <input type="hidden" name="number_of_payments" value="<?= (int) $i ?>">
                </div>
                <div class="card-footer">
                    <div class="flex gap-3 justify-end">
                        <a href="<?= base_url('sales') ?>" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Actions</h3>
                </div>
                <div class="card-body">
                    <p class="form-help">Changes update the sale record and payment types only. Amounts on existing payments cannot be edited here.</p>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupAutocomplete('customer_name', 'customer_id', 'customerAutocomplete', '<?= base_url('customers/suggest') ?>');
    setupAutocomplete('employee_name', 'employee_id', 'employeeAutocomplete', '<?= base_url('employees/suggest') ?>');

    const sendBtn = document.getElementById('sendInvoiceBtn');
    if (sendBtn) {
        sendBtn.addEventListener('click', sendInvoiceEmail);
    }

    document.getElementById('salesEditForm').addEventListener('submit', submitSalesForm);
});

function setupAutocomplete(inputId, hiddenId, dropdownId, sourceUrl) {
    const input = document.getElementById(inputId);
    const hidden = document.getElementById(hiddenId);
    const dropdown = document.getElementById(dropdownId);
    let debounceTimer;

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const term = input.value.trim();
        if (term.length < 1) {
            dropdown.classList.remove('active');
            return;
        }

        debounceTimer = setTimeout(function() {
            fetch(`${sourceUrl}?term=${encodeURIComponent(term)}`, {
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

function sendInvoiceEmail() {
    window.shopsuiteApp.confirm(
        'Send Invoice',
        <?= json_encode(trim(lang('Sales.invoice_confirm') . ' ' . ($sale_info['email'] ?? ''))) ?>,
        () => {
            window.shopsuiteApp.postAction(<?= json_encode(base_url("$controller_name/sendPdf/" . $sale_info['sale_id'])) ?>)
                .then(response => response.json())
                .then(response => {
                    window.shopsuiteApp.showToast(
                        response.success ? 'Success' : 'Error',
                        response.message || '',
                        response.success ? 'success' : 'error'
                    );
                })
                .catch(error => console.error(error));
        }
    );
}

function submitSalesForm(event) {
    event.preventDefault();
    const form = event.target;
    const invoiceInput = document.getElementById('invoice_number');

    const submitForm = () => {
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
                    window.shopsuiteApp.showToast('Success', data.message || 'Sale updated', 'success');
                }
                setTimeout(() => {
                    window.location.href = '<?= base_url('sales') ?>';
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
    };

    if (invoiceInput) {
        const body = new URLSearchParams();
        body.append('sale_id', '<?= (int) $sale_info['sale_id'] ?>');
        body.append('invoice_number', invoiceInput.value);
        body.append(window.shopsuiteApp.getCsrfTokenName(), window.shopsuiteApp.getCsrfToken());

        fetch("<?= esc(base_url("$controller_name/checkInvoiceNumber")) ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: body.toString()
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === 'true') {
                submitForm();
            } else if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', "<?= esc(lang('Sales.invoice_number_duplicate'), 'js') ?>", 'error');
            }
        })
        .catch(submitForm);
    } else {
        submitForm();
    }
}
</script>

<?= view('layouts/modern_footer') ?>
