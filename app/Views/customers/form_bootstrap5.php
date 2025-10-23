<?php
/**
 * Modern Bootstrap 5 Customer Form
 * Completely new implementation - clean and simple
 */
?>

<div class="container-fluid">
    <div id="required_fields_message" class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i><?= lang('Common.fields_required_message') ?>
    </div>
    
    <ul id="error_message_box" class="error_message_box"></ul>
    
    <?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'customer_form', 'class' => 'needs-validation', 'novalidate' => true]) ?>
    
    <!-- Bootstrap 5 Tabs -->
    <ul class="nav nav-tabs mb-3" id="customerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-info" 
                    type="button" role="tab" aria-controls="basic-info" aria-selected="true">
                <i class="bi bi-person-circle me-2"></i><?= lang('Customers.basic_information') ?>
            </button>
        </li>
        <?php if (!empty($stats)): ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats-info" 
                    type="button" role="tab" aria-controls="stats-info" aria-selected="false">
                <i class="bi bi-graph-up me-2"></i><?= lang('Customers.stats_info') ?>
            </button>
        </li>
        <?php endif; ?>
    </ul>
    
    <div class="tab-content" id="customerTabContent">
        <!-- Basic Information Tab -->
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-tab">
            <div class="row g-3">
                <!-- Consent -->
                <div class="col-12">
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
                
                <!-- First Name -->
                <div class="col-md-6">
                    <label for="first_name" class="form-label">
                        <?= lang('Common.first_name') ?> <span class="text-danger">*</span>
                    </label>
                    <?= form_input([
                        'name' => 'first_name',
                        'id' => 'first_name',
                        'class' => 'form-control',
                        'value' => $person_info->first_name ?? '',
                        'required' => true
                    ]) ?>
                    <div class="invalid-feedback">
                        <?= lang('Common.first_name') ?> is required
                    </div>
                </div>
                
                <!-- Last Name -->
                <div class="col-md-6">
                    <label for="last_name" class="form-label">
                        <?= lang('Common.last_name') ?> <span class="text-danger">*</span>
                    </label>
                    <?= form_input([
                        'name' => 'last_name',
                        'id' => 'last_name',
                        'class' => 'form-control',
                        'value' => $person_info->last_name ?? '',
                        'required' => true
                    ]) ?>
                    <div class="invalid-feedback">
                        <?= lang('Common.last_name') ?> is required
                    </div>
                </div>
                
                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= lang('Common.email') ?>
                    </label>
                    <?= form_input([
                        'name' => 'email',
                        'id' => 'email',
                        'type' => 'email',
                        'class' => 'form-control',
                        'value' => $person_info->email ?? ''
                    ]) ?>
                    <div class="invalid-feedback">
                        Please enter a valid email
                    </div>
                </div>
                
                <!-- Phone -->
                <div class="col-md-6">
                    <label for="phone_number" class="form-label">
                        <?= lang('Common.phone_number') ?>
                    </label>
                    <?= form_input([
                        'name' => 'phone_number',
                        'id' => 'phone_number',
                        'class' => 'form-control',
                        'value' => $person_info->phone_number ?? ''
                    ]) ?>
                </div>
                
                <!-- Company Name -->
                <div class="col-md-6">
                    <label for="company_name" class="form-label">
                        <?= lang('Customers.company_name') ?>
                    </label>
                    <?= form_input([
                        'name' => 'company_name',
                        'id' => 'company_name',
                        'class' => 'form-control',
                        'value' => $person_info->company_name ?? ''
                    ]) ?>
                </div>
                
                <!-- Account Number -->
                <div class="col-md-6">
                    <label for="account_number" class="form-label">
                        <?= lang('Customers.account_number') ?>
                    </label>
                    <?= form_input([
                        'name' => 'account_number',
                        'id' => 'account_number',
                        'class' => 'form-control',
                        'value' => $person_info->account_number ?? ''
                    ]) ?>
                </div>
                
                <!-- Comments -->
                <div class="col-12">
                    <label for="comments" class="form-label">
                        <?= lang('Common.comments') ?>
                    </label>
                    <?= form_textarea([
                        'name' => 'comments',
                        'id' => 'comments',
                        'class' => 'form-control',
                        'rows' => 3,
                        'value' => $person_info->comments ?? ''
                    ]) ?>
                </div>
                
                <!-- Address (if needed) -->
                <div class="col-12">
                    <label for="address_1" class="form-label">
                        <?= lang('Common.address_1') ?>
                    </label>
                    <?= form_input([
                        'name' => 'address_1',
                        'id' => 'address_1',
                        'class' => 'form-control',
                        'value' => $person_info->address_1 ?? ''
                    ]) ?>
                </div>
                
                <div class="col-md-6">
                    <label for="city" class="form-label">
                        <?= lang('Common.city') ?>
                    </label>
                    <?= form_input([
                        'name' => 'city',
                        'id' => 'city',
                        'class' => 'form-control',
                        'value' => $person_info->city ?? ''
                    ]) ?>
                </div>
                
                <div class="col-md-6">
                    <label for="zip" class="form-label">
                        <?= lang('Common.zip') ?>
                    </label>
                    <?= form_input([
                        'name' => 'zip',
                        'id' => 'zip',
                        'class' => 'form-control',
                        'value' => $person_info->zip ?? ''
                    ]) ?>
                </div>
            </div>
        </div>
        
        <!-- Stats Tab (if exists) -->
        <?php if (!empty($stats)): ?>
        <div class="tab-pane fade" id="stats-info" role="tabpanel" aria-labelledby="stats-tab">
            <div class="row g-3">
                <div class="col-12">
                    <h6>Customer Statistics</h6>
                    <!-- Add stats display here -->
                    <pre><?= print_r($stats, true) ?></pre>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <?= form_close() ?>
</div>

<script>
// Form validation
(function() {
    'use strict';
    
    const form = document.getElementById('customer_form');
    if (!form) return;
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return false;
        }
        
        // Valid - submit via AJAX
        const formData = new FormData(form);
        const submitBtn = document.querySelector('#modal-submit-btn');
        
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
        }
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modalElement = form.closest('.modal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                }
                
                // Show success
                if (typeof showNotification === 'function') {
                    showNotification(data.message || 'Saved successfully', 'success');
                }
                
                // Refresh table
                if (window.tableManager) {
                    window.tableManager.refresh();
                    if (data.id) {
                        setTimeout(() => {
                            window.tableManager.highlightRows([data.id]);
                        }, 500);
                    }
                }
            } else {
                // Show error
                if (typeof showNotification === 'function') {
                    showNotification(data.message || 'Save failed', 'error');
                }
                
                // Re-enable button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit';
                }
            }
        })
        .catch(error => {
            console.error('Save error:', error);
            if (typeof showNotification === 'function') {
                showNotification('Failed to save', 'error');
            }
            
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit';
            }
        });
    });
})();
</script>
