<?php
/**
 * MODERN EMPLOYEE FORM - Bootstrap 5
 * Complete redesign with modern UI following customer pattern
 */
?>

<style>
.modern-form-section {
    background: #f8f9fa;
    padding: 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.25rem;
}
.modern-form-section h6 {
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-label-modern {
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
}
.form-control-modern {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
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
.permission-item {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 0.75rem;
    border: 1px solid #e9ecef;
}
.permission-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.permission-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}
.permission-sublist {
    margin-left: 2rem;
    margin-top: 0.5rem;
}
.permission-subitem {
    padding: 0.25rem 0;
}
</style>

<div class="container-fluid p-3">
    <!-- Alert Messages -->
    <div id="required_fields_message" class="alert alert-info alert-sm mb-3">
        <i class="bi bi-info-circle me-2"></i><?= lang('Common.fields_required_message') ?>
    </div>
    
    <ul id="error_message_box" class="error_message_box list-unstyled"></ul>

    <?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'employee_form']) ?>

    <!-- Modern Tabs -->
    <ul class="nav nav-tabs modern-nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic-info" type="button">
                <i class="bi bi-person-circle me-1"></i>Basic Info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#login-info" type="button">
                <i class="bi bi-key me-1"></i>Login & Security
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#permissions-info" type="button">
                <i class="bi bi-shield-lock me-1"></i>Permissions
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: Basic Information -->
        <div class="tab-pane fade show active" id="basic-info">
            
            <!-- Personal Details -->
            <div class="modern-form-section">
                <h6><i class="bi bi-person me-2"></i>Personal Details</h6>
                <div class="row g-3">
                    <!-- First Name -->
                    <div class="col-md-6">
                        <label class="form-label-modern">
                            <?= lang('Common.first_name') ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input([
                            'name' => 'first_name',
                            'id' => 'first_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->first_name ?? '',
                            'required' => true
                        ]) ?>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label class="form-label-modern">
                            <?= lang('Common.last_name') ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input([
                            'name' => 'last_name',
                            'id' => 'last_name',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->last_name ?? '',
                            'required' => true
                        ]) ?>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.gender') ?></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <?= form_radio([
                                    'name' => 'gender',
                                    'id' => 'gender_male',
                                    'value' => 1,
                                    'checked' => ($person_info->gender ?? '') === '1',
                                    'class' => 'form-check-input'
                                ]) ?>
                                <label class="form-check-label" for="gender_male">
                                    <?= lang('Common.gender_male') ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <?= form_radio([
                                    'name' => 'gender',
                                    'id' => 'gender_female',
                                    'value' => 0,
                                    'checked' => ($person_info->gender ?? '') === '0',
                                    'class' => 'form-check-input'
                                ]) ?>
                                <label class="form-check-label" for="gender_female">
                                    <?= lang('Common.gender_female') ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="modern-form-section">
                <h6><i class="bi bi-envelope me-2"></i>Contact Information</h6>
                <div class="row g-3">
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.email') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <?= form_input([
                                'name' => 'email',
                                'id' => 'email',
                                'type' => 'email',
                                'class' => 'form-control form-control-modern',
                                'value' => $person_info->email ?? ''
                            ]) ?>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.phone_number') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <?= form_input([
                                'name' => 'phone_number',
                                'id' => 'phone_number',
                                'class' => 'form-control form-control-modern',
                                'value' => $person_info->phone_number ?? ''
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="modern-form-section">
                <h6><i class="bi bi-geo-alt me-2"></i>Address</h6>
                <div class="row g-3">
                    <!-- Address 1 -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.address_1') ?></label>
                        <?= form_input([
                            'name' => 'address_1',
                            'id' => 'address_1',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->address_1 ?? ''
                        ]) ?>
                    </div>

                    <!-- Address 2 -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.address_2') ?></label>
                        <?= form_input([
                            'name' => 'address_2',
                            'id' => 'address_2',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->address_2 ?? ''
                        ]) ?>
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.city') ?></label>
                        <?= form_input([
                            'name' => 'city',
                            'id' => 'city',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->city ?? ''
                        ]) ?>
                    </div>

                    <!-- State -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.state') ?></label>
                        <?= form_input([
                            'name' => 'state',
                            'id' => 'state',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->state ?? ''
                        ]) ?>
                    </div>

                    <!-- ZIP -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.zip') ?></label>
                        <?= form_input([
                            'name' => 'zip',
                            'id' => 'zip',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->zip ?? ''
                        ]) ?>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label class="form-label-modern"><?= lang('Common.country') ?></label>
                        <?= form_input([
                            'name' => 'country',
                            'id' => 'country',
                            'class' => 'form-control form-control-modern',
                            'value' => $person_info->country ?? ''
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="modern-form-section">
                <h6><i class="bi bi-chat-left-text me-2"></i>Notes</h6>
                <?= form_textarea([
                    'name' => 'comments',
                    'id' => 'comments',
                    'class' => 'form-control form-control-modern',
                    'rows' => 3,
                    'value' => $person_info->comments ?? '',
                    'placeholder' => 'Additional notes about this employee...'
                ]) ?>
            </div>
        </div>

        <!-- TAB 2: Login & Security -->
        <div class="tab-pane fade" id="login-info">
            
            <!-- Login Credentials -->
            <div class="modern-form-section">
                <h6><i class="bi bi-person-lock me-2"></i>Login Credentials</h6>
                <div class="row g-3">
                    <!-- Username -->
                    <div class="col-md-12">
                        <label class="form-label-modern">
                            <?= lang('Employees.username') ?> <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <?= form_input([
                                'name' => 'username',
                                'id' => 'username',
                                'class' => 'form-control form-control-modern',
                                'value' => $person_info->username ?? '',
                                'required' => true,
                                'autocomplete' => 'off'
                            ]) ?>
                        </div>
                        <small class="text-muted">Minimum 5 characters</small>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label-modern">
                            <?= lang('Employees.password') ?> 
                            <?php if (empty($person_info->person_id)): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <?= form_password([
                                'name' => 'password',
                                'id' => 'password',
                                'class' => 'form-control form-control-modern',
                                'autocomplete' => 'new-password'
                            ]) ?>
                        </div>
                        <small class="text-muted">
                            <?php if (empty($person_info->person_id)): ?>
                                Minimum 8 characters
                            <?php else: ?>
                                Leave blank to keep current password
                            <?php endif; ?>
                        </small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6">
                        <label class="form-label-modern">
                            <?= lang('Employees.repeat_password') ?>
                            <?php if (empty($person_info->person_id)): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <?= form_password([
                                'name' => 'repeat_password',
                                'id' => 'repeat_password',
                                'class' => 'form-control form-control-modern',
                                'autocomplete' => 'new-password'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Preference -->
            <div class="modern-form-section">
                <h6><i class="bi bi-globe me-2"></i>Preferences</h6>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label-modern"><?= lang('Employees.language') ?></label>
                        <?php
                        $languages = get_languages();
                        $languages[':'] = lang('Employees.system_language');
                        $language_code = current_language_code();
                        $language = current_language();

                        if ($language_code === current_language_code(true)) {
                            $language_code = '';
                            $language = '';
                        }

                        echo form_dropdown(
                            'language',
                            $languages,
                            "$language_code:$language",
                            ['class' => 'form-select form-control-modern']
                        );
                        ?>
                        <small class="text-muted">Choose preferred interface language</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Permissions -->
        <div class="tab-pane fade" id="permissions-info">
            <?= view('employees/form_permissions_crud', [
                'all_modules' => $all_modules,
                'all_subpermissions' => $all_subpermissions
            ]) ?>
        </div>
    </div>

    <?= form_close() ?>
</div>

<script>
$(document).ready(function() {
    console.log('🔧 Modern Employee Form Loaded');

    // Module checkbox handler
    $('.module-checkbox').each(function() {
        const $moduleCheckbox = $(this);
        const $permissionItem = $moduleCheckbox.closest('.permission-item');
        const $subCheckboxes = $permissionItem.find('.subpermission-checkbox');
        const $menuGroup = $permissionItem.find('.module-menu-group');

        // Update sub-permissions state
        const updateSubPermissions = function(checked) {
            $subCheckboxes.prop('disabled', !checked);
            $menuGroup.prop('disabled', !checked);
            if (!checked) {
                $subCheckboxes.prop('checked', false);
            }
        };

        // Initialize state
        updateSubPermissions($moduleCheckbox.is(':checked'));

        // Handle changes
        $moduleCheckbox.change(function() {
            updateSubPermissions($(this).is(':checked'));
        });
    });

    // Form validation
    $.validator.addMethod('module', function(value, element) {
        return $('#permission_list .module-checkbox').is(':checked');
    }, "<?= lang('Employees.subpermission_required') ?>");

    $('#employee_form').validate({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('employeeModal'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Refresh table if it exists
                        if (window.employeesTable) {
                            window.employeesTable.refresh();
                        } else {
                            // Fallback: reload page
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred', 'error');
                },
                dataType: 'json'
            });
        },
        errorLabelContainer: '#error_message_box',
        rules: {
            first_name: 'required',
            last_name: 'required',
            username: {
                required: true,
                minlength: 5,
                remote: '<?= base_url("$controller_name/checkUsername/$employee_id") ?>'
            },
            password: {
                <?php if (empty($person_info->person_id)): ?>
                required: true,
                <?php endif; ?>
                minlength: 8
            },
            repeat_password: {
                equalTo: '#password'
            },
            email: 'email'
        },
        messages: {
            first_name: "<?= lang('Common.first_name_required') ?>",
            last_name: "<?= lang('Common.last_name_required') ?>",
            username: {
                required: "<?= lang('Employees.username_required') ?>",
                minlength: "<?= lang('Employees.username_minlength') ?>",
                remote: "<?= lang('Employees.username_duplicate') ?>"
            },
            password: {
                <?php if (empty($person_info->person_id)): ?>
                required: "<?= lang('Employees.password_required') ?>",
                <?php endif; ?>
                minlength: "<?= lang('Employees.password_minlength') ?>"
            },
            repeat_password: {
                equalTo: "<?= lang('Employees.password_must_match') ?>"
            },
            email: "<?= lang('Common.email_invalid_format') ?>"
        }
    });
});
</script>
