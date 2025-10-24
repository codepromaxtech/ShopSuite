<?php
/**
 * ROLE FORM - Create/Edit Role and Assign Permissions
 * @var object $role_info
 * @var array $all_permissions
 */

$is_new = ($role_info->role_id == -1);
$is_system = ($role_info->is_system_role == 1);

// Build array of current permissions for easy lookup
$current_permissions = [];
if (!empty($role_info->permissions)) {
    foreach ($role_info->permissions as $perm) {
        $current_permissions[$perm->permission_id] = $perm->menu_group;
    }
}
?>

<div class="container-fluid p-3">
    <?= form_open("roles/save/{$role_info->role_id}", ['id' => 'role_form', 'class' => 'needs-validation', 'novalidate' => true]) ?>
    
    <!-- Role Details -->
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Role Information</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="role_name" class="form-label">Role Name *</label>
                    <input type="text" 
                           class="form-control" 
                           id="role_name" 
                           name="role_name" 
                           value="<?= esc($role_info->role_name) ?>"
                           <?= $is_system ? 'readonly' : '' ?>
                           required>
                    <?php if ($is_system): ?>
                        <small class="text-muted">System role name cannot be changed</small>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="role_description" class="form-label">Description</label>
                    <input type="text" 
                           class="form-control" 
                           id="role_description" 
                           name="role_description" 
                           value="<?= esc($role_info->role_description) ?>"
                           <?= $is_system ? 'readonly' : '' ?>>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="bi bi-key me-2"></i>Module Permissions</h6>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="selectAllPermissions()">
                    <i class="bi bi-check-all"></i> Select All
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="deselectAllPermissions()">
                    <i class="bi bi-x"></i> Deselect All
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php foreach ($all_permissions as $module): ?>
                <div class="module-permissions mb-4">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-folder me-2"></i>
                        <?= lang('Module.' . $module['module_id']) ?>
                        <small class="text-muted">(<?= count($module['permissions']) ?> permissions)</small>
                    </h6>
                    
                    <div class="row g-2">
                        <?php foreach ($module['permissions'] as $perm): ?>
                            <?php 
                            $is_checked = isset($current_permissions[$perm->permission_id]);
                            $current_menu = $current_permissions[$perm->permission_id] ?? 'home';
                            ?>
                            <div class="col-md-6">
                                <div class="permission-item p-2 rounded border <?= $is_checked ? 'border-primary bg-light' : '' ?>">
                                    <div class="form-check">
                                        <input class="form-check-input permission-checkbox" 
                                               type="checkbox" 
                                               name="permissions[<?= esc($perm->permission_id) ?>]"
                                               id="perm_<?= esc($perm->permission_id) ?>"
                                               value="<?= $current_menu ?>"
                                               data-permission-id="<?= esc($perm->permission_id) ?>"
                                               <?= $is_checked ? 'checked' : '' ?>>
                                        <label class="form-check-label flex-grow-1" for="perm_<?= esc($perm->permission_id) ?>">
                                            <strong><?= esc($perm->permission_id) ?></strong>
                                        </label>
                                    </div>
                                    
                                    <div class="mt-2 permission-menu-group" style="<?= $is_checked ? '' : 'display: none;' ?>">
                                        <select class="form-select form-select-sm menu-group-select" 
                                                data-permission-id="<?= esc($perm->permission_id) ?>">
                                            <option value="home" <?= $current_menu == 'home' ? 'selected' : '' ?>>Home Menu</option>
                                            <option value="office" <?= $current_menu == 'office' ? 'selected' : '' ?>>Office Menu</option>
                                            <option value="both" <?= $current_menu == 'both' ? 'selected' : '' ?>>Both Menus</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($all_permissions)): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No permissions available in the system.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?= form_close() ?>
</div>

<style>
.permission-item {
    transition: all 0.3s ease;
}

.permission-item:hover {
    background-color: #f8f9fa !important;
}

.permission-checkbox:checked ~ label {
    font-weight: 600;
    color: var(--primary-color);
}
</style>

<script>
$(document).ready(function() {
    console.log('🔐 Role Form Loaded');
    
    // Connect modal submit button to form
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    if (modalSubmitBtn) {
        modalSubmitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Save Role';
        modalSubmitBtn.addEventListener('click', function() {
            document.getElementById('role_form').dispatchEvent(new Event('submit'));
        });
    }

    // Handle permission checkbox changes
    $('.permission-checkbox').on('change', function() {
        const permissionId = $(this).data('permission-id');
        const isChecked = $(this).is(':checked');
        const parent = $(this).closest('.permission-item');
        const menuGroup = parent.find('.permission-menu-group');
        
        if (isChecked) {
            parent.addClass('border-primary bg-light');
            menuGroup.show();
            // Set checkbox value to current menu group selection
            const menuValue = parent.find('.menu-group-select').val();
            $(this).val(menuValue);
        } else {
            parent.removeClass('border-primary bg-light');
            menuGroup.hide();
        }
    });

    // Handle menu group selection changes
    $('.menu-group-select').on('change', function() {
        const permissionId = $(this).data('permission-id');
        const menuValue = $(this).val();
        const checkbox = $('#perm_' + permissionId);
        checkbox.val(menuValue);
    });

    // Form submission
    const form = document.getElementById('role_form');
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
        
        // Build permissions object with menu_group
        const permissionsData = {};
        $('.permission-checkbox:checked').each(function() {
            const permId = $(this).attr('name').match(/\[(.*?)\]/)[1];
            const menuGroup = $(this).val();
            permissionsData[permId] = menuGroup;
        });
        
        // Remove old permissions data and add new structured data
        formData.delete('permissions');
        for (const [permId, menuGroup] of Object.entries(permissionsData)) {
            formData.append('permissions[' + permId + ']', menuGroup);
        }
        
        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message || 'Role saved successfully', 'success');
                    setTimeout(() => {
                        if (typeof hideModal === 'function') {
                            hideModal();
                        }
                        location.reload();
                    }, 500);
                } else {
                    showNotification(response.message || 'Failed to save role', 'error');
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

function selectAllPermissions() {
    $('.permission-checkbox').prop('checked', true).trigger('change');
}

function deselectAllPermissions() {
    $('.permission-checkbox').prop('checked', false).trigger('change');
}
</script>
