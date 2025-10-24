<?php
/**
 * MODERN CUSTOMER FORM - Bootstrap 5
 * Complete redesign with modern UI, all fields included
 */
?>

<style>
.modern-form-modal .modal-dialog {
    max-width: 900px;
}
.modern-form-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}
.modern-form-section h6 {
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-label-modern {
    font-size: 0.85rem;
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
}
.form-control-modern {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
}
.modern-radio-group {
    display: flex;
    gap: 1rem;
}
.modern-radio-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.modern-nav-tabs {
    border-bottom: 2px solid #e9ecef;
}
.modern-nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-bottom: 3px solid transparent;
}
.modern-nav-tabs .nav-link:hover {
    border-bottom-color: #dee2e6;
}
.modern-nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
    background: none;
}
</style>

<div class="container-fluid p-3">
    <!-- Alert Messages -->
    <div id="required_fields_message" class="alert alert-info alert-sm mb-3" style="font-size: 0.85rem;">
        <i class="bi bi-info-circle me-2"></i><?= lang('Common.fields_required_message') ?>
    </div>
    
    <ul id="error_message_box" class="error_message_box"></ul>

    <?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'customer_form', 'class' => 'needs-validation', 'novalidate' => true]) ?>
    
    <!-- Hidden Required Fields -->
    <?= form_hidden('employee_id', $person_info->employee_id ?? '') ?>
    <?= form_hidden('date', $person_info->date ?? date('Y-m-d H:i:s')) ?>

    <!-- Modern Tabs -->
    <ul class="nav nav-tabs modern-nav-tabs mb-3" id="customerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-info"
                    type="button" role="tab" aria-controls="basic-info" aria-selected="true">
                <i class="bi bi-person-circle me-1"></i>Basic Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="business-tab" data-bs-toggle="tab" data-bs-target="#business-info"
                    type="button" role="tab" aria-controls="business-info" aria-selected="false">
                <i class="bi bi-building me-1"></i>Business
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-info"
                    type="button" role="tab" aria-controls="address-info" aria-selected="false">
                <i class="bi bi-geo-alt me-1"></i>Address
            </button>
        </li>
        <?php if (!empty($stats)): ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats-info"
                    type="button" role="tab" aria-controls="stats-info" aria-selected="false">
                <i class="bi bi-graph-up me-1"></i>Stats
            </button>
        </li>
        <?php endif; ?>
    </ul>

    <div class="tab-content" id="customerTabContent">
        <!-- TAB 1: Basic Information -->
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-tab">
            
            <!-- Consent Section -->
            <div class="modern-form-section">
                <h6><i class="bi bi-shield-check me-2"></i>Privacy & Consent</h6>
                <div class="form-check">
                    <?= form_checkbox([
                        'name' => 'consent',
                        'id' => 'consent',
                        'value' => 1,
                        'checked' => $person_info->consent == '' ? !$config['enforce_privacy'] : (bool)$person_info->consent,
                        'class' => 'form-check-input'
                    ]) ?>
                    <label class="form-check-label" for="consent">
                        <?= lang('Customers.consent') ?> <span class="text-danger">*</span>
                    </label>
                </div>
            </div>

            <!-- Personal Details Section -->
            <div class="modern-form-section">
                <h6><i class="bi bi-person me-2"></i>Personal Details</h6>
                <div class="row g-3">
                    <!-- First Name -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label form-label-modern">
                            <?= lang('Common.first_name') ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input([
                            'name' => 'first_name',
                            'id' => 'first_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->first_name ?? '',
                            'required' => true
                        ]) ?>
                        <div class="invalid-feedback">First name is required</div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label for="last_name" class="form-label form-label-modern">
                            <?= lang('Common.last_name') ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input([
                            'name' => 'last_name',
                            'id' => 'last_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->last_name ?? '',
                            'required' => true
                        ]) ?>
                        <div class="invalid-feedback">Last name is required</div>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label form-label-modern"><?= lang('Common.gender') ?></label>
                        <div class="modern-radio-group">
                            <div class="modern-radio-item">
                                <input type="radio" class="form-check-input" name="gender" id="gender_male" value="1" 
                                    <?= $person_info->gender === '1' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="gender_male"><?= lang('Common.gender_male') ?></label>
                            </div>
                            <div class="modern-radio-item">
                                <input type="radio" class="form-check-input" name="gender" id="gender_female" value="0" 
                                    <?= $person_info->gender === '0' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="gender_female"><?= lang('Common.gender_female') ?></label>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label form-label-modern">
                            <i class="bi bi-envelope me-1"></i><?= lang('Common.email') ?>
                        </label>
                        <?= form_input([
                            'name' => 'email',
                            'id' => 'email',
                            'type' => 'email',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->email ?? ''
                        ]) ?>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label form-label-modern">
                            <i class="bi bi-telephone me-1"></i><?= lang('Common.phone_number') ?>
                        </label>
                        <?= form_input([
                            'name' => 'phone_number',
                            'id' => 'phone_number',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->phone_number ?? ''
                        ]) ?>
                    </div>

                    <!-- Comments -->
                    <div class="col-12">
                        <label for="comments" class="form-label form-label-modern">
                            <i class="bi bi-chat-text me-1"></i><?= lang('Common.comments') ?>
                        </label>
                        <?= form_textarea([
                            'name' => 'comments',
                            'id' => 'comments',
                            'class' => 'form-control form-control-modern',
                            'rows' => 3,
                            'value' => $person_info->comments ?? ''
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Business Information -->
        <div class="tab-pane fade" id="business-info" role="tabpanel" aria-labelledby="business-tab">
            
            <!-- Company Details -->
            <div class="modern-form-section">
                <h6><i class="bi bi-building me-2"></i>Company Details</h6>
                <div class="row g-3">
                    <!-- Company Name -->
                    <div class="col-md-8">
                        <label for="customer_company_name" class="form-label form-label-modern">
                            <?= lang('Customers.company_name') ?>
                        </label>
                        <?= form_input([
                            'name' => 'company_name',
                            'id' => 'customer_company_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->company_name ?? ''
                        ]) ?>
                    </div>

                    <!-- Account Number -->
                    <div class="col-md-4">
                        <label for="account_number" class="form-label form-label-modern">
                            <?= lang('Customers.account_number') ?>
                        </label>
                        <?= form_input([
                            'name' => 'account_number',
                            'id' => 'account_number',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->account_number ?? ''
                        ]) ?>
                    </div>

                    <!-- Tax ID -->
                    <div class="col-md-6">
                        <label for="tax_id" class="form-label form-label-modern">
                            <?= lang('Customers.tax_id') ?>
                        </label>
                        <?= form_input([
                            'name' => 'tax_id',
                            'id' => 'tax_id',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->tax_id ?? ''
                        ]) ?>
                    </div>

                    <!-- Taxable -->
                    <div class="col-md-6">
                        <label class="form-label form-label-modern"><?= lang('Customers.taxable') ?></label>
                        <div class="form-check">
                            <?= form_checkbox('taxable', 1, $person_info->taxable == 1, ['class' => 'form-check-input', 'id' => 'taxable']) ?>
                            <label class="form-check-label" for="taxable">Customer is taxable</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discount Settings -->
            <div class="modern-form-section">
                <h6><i class="bi bi-percent me-2"></i>Discount Settings</h6>
                <div class="row g-3">
                    <!-- Discount Type -->
                    <div class="col-md-6">
                        <label class="form-label form-label-modern"><?= lang('Customers.discount_type') ?></label>
                        <div class="modern-radio-group">
                            <div class="modern-radio-item">
                                <input type="radio" class="form-check-input" name="discount_type" id="discount_percent" value="0" 
                                    <?= $person_info->discount_type == PERCENT ? 'checked' : '' ?>>
                                <label class="form-check-label" for="discount_percent"><?= lang('Customers.discount_percent') ?></label>
                            </div>
                            <div class="modern-radio-item">
                                <input type="radio" class="form-check-input" name="discount_type" id="discount_fixed" value="1" 
                                    <?= $person_info->discount_type == FIXED ? 'checked' : '' ?>>
                                <label class="form-check-label" for="discount_fixed"><?= lang('Customers.discount_fixed') ?></label>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Amount -->
                    <div class="col-md-6">
                        <label for="discount" class="form-label form-label-modern">
                            <?= lang('Customers.discount') ?>
                        </label>
                        <?= form_input([
                            'name' => 'discount',
                            'id' => 'discount',
                            'class' => 'form-control form-control-modern',
                            'type' => 'number',
                            'step' => '0.01',
                            'value' => $person_info->discount_type === FIXED ? to_currency_no_money($person_info->discount) : to_decimals($person_info->discount)
                        ]) ?>
                    </div>
                </div>
            </div>

            <?php if ($config['customer_reward_enable']): ?>
            <!-- Rewards Program -->
            <div class="modern-form-section">
                <h6><i class="bi bi-gift me-2"></i>Rewards Program</h6>
                <div class="row g-3">
                    <!-- Package -->
                    <div class="col-md-6">
                        <label for="package_id" class="form-label form-label-modern">
                            <?= lang('Customers.rewards_package') ?>
                        </label>
                        <?= form_dropdown(
                            'package_id',
                            $packages,
                            $selected_package,
                            ['class' => 'form-select form-control-modern', 'id' => 'package_id']
                        ) ?>
                    </div>

                    <!-- Available Points -->
                    <div class="col-md-6">
                        <label for="available_points" class="form-label form-label-modern">
                            <?= lang('Customers.available_points') ?>
                        </label>
                        <?= form_input([
                            'name' => 'available_points',
                            'id' => 'available_points',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->points ?? 0,
                            'disabled' => true
                        ]) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($use_destination_based_tax): ?>
            <!-- Tax Code -->
            <div class="modern-form-section">
                <h6><i class="bi bi-receipt me-2"></i>Tax Code</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="sales_tax_code_name" class="form-label form-label-modern">
                            <?= lang('Customers.tax_code') ?>
                        </label>
                        <?= form_input([
                            'name' => 'sales_tax_code_name',
                            'id' => 'sales_tax_code_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $sales_tax_code_label ?? ''
                        ]) ?>
                        <?= form_hidden('sales_tax_code_id', $person_info->sales_tax_code_id) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- System Info -->
            <div class="modern-form-section">
                <h6><i class="bi bi-info-circle me-2"></i>System Information</h6>
                <div class="row g-3">
                    <!-- Date Created -->
                    <div class="col-md-6">
                        <label for="datetime" class="form-label form-label-modern">
                            <i class="bi bi-calendar me-1"></i><?= lang('Customers.date') ?>
                        </label>
                        <?= form_input([
                            'name' => 'date',
                            'id' => 'datetime',
                            'class' => 'form-control form-control-modern',
                            'value' => to_datetime(strtotime($person_info->date)),
                            'readonly' => true
                        ]) ?>
                    </div>

                    <!-- Created By -->
                    <div class="col-md-6">
                        <label for="employee" class="form-label form-label-modern">
                            <i class="bi bi-person-badge me-1"></i><?= lang('Customers.employee') ?>
                        </label>
                        <?= form_input([
                            'name' => 'employee',
                            'id' => 'employee',
                            'class' => 'form-control form-control-modern',
                            'value' => $employee ?? '',
                            'readonly' => true
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Address Information -->
        <div class="tab-pane fade" id="address-info" role="tabpanel" aria-labelledby="address-tab">
            <div class="modern-form-section">
                <h6><i class="bi bi-geo-alt me-2"></i>Complete Address</h6>
                <div class="row g-3">
                    <!-- Address Line 1 -->
                    <div class="col-12">
                        <label for="address_1" class="form-label form-label-modern">
                            <?= lang('Common.address_1') ?>
                        </label>
                        <?= form_input([
                            'name' => 'address_1',
                            'id' => 'address_1',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->address_1 ?? ''
                        ]) ?>
                    </div>

                    <!-- Address Line 2 -->
                    <div class="col-12">
                        <label for="address_2" class="form-label form-label-modern">
                            <?= lang('Common.address_2') ?>
                        </label>
                        <?= form_input([
                            'name' => 'address_2',
                            'id' => 'address_2',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->address_2 ?? ''
                        ]) ?>
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <label for="city" class="form-label form-label-modern">
                            <?= lang('Common.city') ?>
                        </label>
                        <?= form_input([
                            'name' => 'city',
                            'id' => 'city',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->city ?? ''
                        ]) ?>
                    </div>

                    <!-- State -->
                    <div class="col-md-6">
                        <label for="state" class="form-label form-label-modern">
                            <?= lang('Common.state') ?>
                        </label>
                        <?= form_input([
                            'name' => 'state',
                            'id' => 'state',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->state ?? ''
                        ]) ?>
                    </div>

                    <!-- ZIP/Postal Code -->
                    <div class="col-md-6">
                        <label for="postcode" class="form-label form-label-modern">
                            <?= lang('Common.zip') ?>
                        </label>
                        <?= form_input([
                            'name' => 'zip',
                            'id' => 'postcode',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->zip ?? ''
                        ]) ?>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label for="country" class="form-label form-label-modern">
                            <?= lang('Common.country') ?>
                        </label>
                        <?= form_input([
                            'name' => 'country',
                            'id' => 'country',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->country ?? ''
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Statistics (if available) -->
        <?php if (!empty($stats)): ?>
        <div class="tab-pane fade" id="stats-info" role="tabpanel" aria-labelledby="stats-tab">
            <div class="modern-form-section">
                <h6><i class="bi bi-graph-up me-2"></i>Customer Statistics</h6>
                <div class="row g-3">
                    <?php foreach ($stats as $key => $value): ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body py-2">
                                <small class="text-muted"><?= ucwords(str_replace('_', ' ', $key)) ?></small>
                                <h5 class="mb-0"><?= $value ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?= form_close() ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    console.log('✅ Modern Customer Form Loaded');
    
    // Connect modal submit button to form
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    if (modalSubmitBtn) {
        modalSubmitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Save Customer';
        modalSubmitBtn.addEventListener('click', function() {
            document.getElementById('customer_form').dispatchEvent(new Event('submit'));
        });
    }

    // Address autocomplete using Nominatim
    <?php if (isset($config['country_codes']) && !empty($config['country_codes'])): ?>
    if (typeof nominatim !== 'undefined') {
        nominatim.init({
        fields: {
            postcode: {
                dependencies: ["postcode", "city", "state", "country"],
                response: {
                    field: 'postalcode',
                    format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                }
            },
            city: {
                dependencies: ["postcode", "city", "state", "country"],
                response: {
                    format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                }
            },
            state: {
                dependencies: ["state", "country"]
            },
            country: {
                dependencies: ["state", "country"]
            }
        },
            language: '<?= current_language_code() ?>',
            country_codes: '<?= esc($config['country_codes'], 'js') ?>'
        });
    }
    <?php endif; ?>

    // Native HTML5 form validation and submission
    const form = document.getElementById('customer_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return false;
        }
        
        const submitBtn = document.getElementById('modal-submit-btn');
        const originalText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Saving...';
        }
        
        const formData = new FormData(form);
        
        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message || 'Customer saved successfully', 'success');
                    if (typeof window.customersTable !== 'undefined' && window.customersTable.refresh) {
                        window.customersTable.refresh();
                    }
                    if (typeof hideModal === 'function') {
                        setTimeout(() => hideModal(), 500);
                    } else if (typeof closeModal === 'function') {
                        setTimeout(() => closeModal(), 500);
                    }
                } else {
                    showNotification(response.message || 'Failed to save customer', 'error');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Save error:', error);
                showNotification('An error occurred while saving', 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
        
        return false;
    });
});
</script>
