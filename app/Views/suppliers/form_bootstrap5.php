<?php
/**
 * MODERN SUPPLIER FORM - Bootstrap 5
 * Complete redesign with modern UI
 */
?>

<style>
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
</style>

<div class="container-fluid p-3">
    <!-- Alert Messages -->
    <div id="required_fields_message" class="alert alert-info alert-sm mb-3" style="font-size: 0.85rem;">
        <i class="bi bi-info-circle me-2"></i><?= lang('Common.fields_required_message') ?>
    </div>
    
    <ul id="error_message_box" class="error_message_box"></ul>

    <?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'supplier_form', 'class' => 'needs-validation', 'novalidate' => true]) ?>

    <!-- Company Information -->
    <div class="modern-form-section">
        <h6><i class="bi bi-building me-2"></i>Company Information</h6>
        <div class="row g-3">
            <!-- Company Name -->
            <div class="col-md-8">
                <label for="company_name_input" class="form-label form-label-modern">
                    <?= lang('Suppliers.company_name') ?> <span class="text-danger">*</span>
                </label>
                <?= form_input([
                    'name' => 'company_name',
                    'id' => 'company_name_input',
                    'class' => 'form-control form-control-modern',
                    'value' => html_entity_decode($person_info->company_name ?? ''),
                    'required' => true
                ]) ?>
                <div class="invalid-feedback">Company name is required</div>
            </div>

            <!-- Category -->
            <div class="col-md-4">
                <label for="category" class="form-label form-label-modern">
                    <?= lang('Suppliers.category') ?> <span class="text-danger">*</span>
                </label>
                <?= form_dropdown('category', $categories, $person_info->category ?? '', [
                    'class' => 'form-select form-control-modern',
                    'id' => 'category',
                    'required' => true
                ]) ?>
                <div class="invalid-feedback">Category is required</div>
            </div>

            <!-- Agency Name -->
            <div class="col-12">
                <label for="agency_name_input" class="form-label form-label-modern">
                    <?= lang('Suppliers.agency_name') ?>
                </label>
                <?= form_input([
                    'name' => 'agency_name',
                    'id' => 'agency_name_input',
                    'class' => 'form-control form-control-modern',
                    'value' => $person_info->agency_name ?? ''
                ]) ?>
            </div>

            <!-- Account Number -->
            <div class="col-md-6">
                <label for="account_number" class="form-label form-label-modern">
                    <?= lang('Suppliers.account_number') ?>
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
                    <?= lang('Suppliers.tax_id') ?>
                </label>
                <?= form_input([
                    'name' => 'tax_id',
                    'id' => 'tax_id',
                    'class' => 'form-control form-control-modern',
                    'value' => $person_info->tax_id ?? ''
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Contact Person -->
    <div class="modern-form-section">
        <h6><i class="bi bi-person me-2"></i>Contact Person</h6>
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
                <div class="invalid-feedback">Please enter a valid email</div>
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
        </div>
    </div>

    <!-- Address Information -->
    <div class="modern-form-section">
        <h6><i class="bi bi-geo-alt me-2"></i>Address</h6>
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

            <!-- ZIP -->
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

    <!-- Form Actions -->
    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
            <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="submit" class="btn btn-primary" id="submit_button">
            <i class="bi bi-check-circle me-1"></i>Save Supplier
        </button>
    </div>

    <?= form_close() ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    console.log('✅ Modern Supplier Form Loaded');

    // Address autocomplete (only if nominatim library is loaded)
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

    // Form validation
    $('#supplier_form').validate({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    if (response.success) {
                        showNotification('Supplier saved successfully', 'success');
                        
                        // Reload the data table if it exists
                        if (typeof window.suppliersTable !== 'undefined' && window.suppliersTable.refresh) {
                            window.suppliersTable.refresh();
                        }
                        
                        // Close modal if function exists
                        if (typeof hideModal === 'function') {
                            setTimeout(() => hideModal(), 500);
                        } else if (typeof closeModal === 'function') {
                            setTimeout(() => closeModal(), 500);
                        }
                    } else {
                        showNotification(response.message || 'Failed to save supplier', 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred', 'error');
                },
                dataType: 'json'
            });
            return false;
        },
        rules: {
            company_name: "required",
            first_name: "required",
            last_name: "required",
            email: {
                email: true
            }
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-6, .col-md-8, .col-12, .col-md-4').append(error);
        }
    });
});
</script>
