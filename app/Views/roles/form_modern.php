<?php
/**
 * MODERN ROLE FORM - Create/Edit Role and Assign Permissions
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

$title = ($is_new ? 'Add New' : 'Edit') . ' Role - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            <div>
                <h1><?= $is_new ? 'Add New' : 'Edit' ?> Role</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('roles') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Roles
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('roles') ?>">Roles</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_new ? 'Add' : 'Edit' ?></div>
    </div>
</div>

<?= form_open("roles/save/{$role_info->role_id}", ['id' => 'role_form', 'class' => 'form-modern']) ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Role Information -->
        <div class="card" style="margin-bottom: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">Role Information</h3>
            </div>
            <div class="card-body">
                <?php if ($is_system): ?>
                    <div class="alert alert-info" style="margin-bottom: var(--space-4);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: var(--space-2);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        This is a system role. The name cannot be changed.
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="role_name" class="form-label form-label-required">Role Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="role_name" 
                           name="role_name" 
                           value="<?= esc($role_info->role_name) ?>"
                           <?= $is_system ? 'readonly' : '' ?>
                           required>
                </div>
                
                <div class="form-group">
                    <label for="role_description" class="form-label">Description</label>
                    <textarea class="form-control" 
                              id="role_description" 
                              name="role_description" 
                              rows="3"
                              <?= $is_system ? 'readonly' : '' ?>><?= esc($role_info->role_description) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-header-title">Module Permissions</h3>
                <div style="display: flex; gap: var(--space-2);">
                    <button type="button" class="btn btn-sm btn-outline" onclick="selectAllPermissions()">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="deselectAllPermissions()">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Deselect All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php foreach ($all_permissions as $module): ?>
                    <div class="permission-module" style="margin-bottom: var(--space-6);">
                        <div style="border-bottom: 2px solid var(--border-primary); padding-bottom: var(--space-2); margin-bottom: var(--space-4);">
                            <h4 style="font-size: var(--text-lg); font-weight: var(--font-semibold); margin: 0;">
                                <?= lang('Module.' . $module['module_id']) ?>
                                <span style="color: var(--text-tertiary); font-size: var(--text-sm); font-weight: var(--font-normal);">(<?= count($module['permissions']) ?> permissions)</span>
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php foreach ($module['permissions'] as $perm): ?>
                                <?php 
                                $is_checked = isset($current_permissions[$perm->permission_id]);
                                $current_menu = $current_permissions[$perm->permission_id] ?? 'home';
                                ?>
                                <div class="permission-item" style="padding: var(--space-3); border: 1px solid var(--border-primary); border-radius: var(--radius-md); <?= $is_checked ? 'background: var(--primary-50); border-color: var(--primary-300);' : '' ?>">
                                    <label style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer;">
                                        <input class="permission-checkbox" 
                                               type="checkbox" 
                                               name="perm_enabled[<?= esc($perm->permission_id) ?>]"
                                               id="perm_<?= esc($perm->permission_id) ?>"
                                               value="1"
                                               data-permission-id="<?= esc($perm->permission_id) ?>"
                                               <?= $is_checked ? 'checked' : '' ?>
                                               style="width: 18px; height: 18px; cursor: pointer;">
                                        <span style="font-weight: var(--font-semibold); flex-grow: 1;"><?= esc($perm->permission_id) ?></span>
                                    </label>
                                    
                                    <div class="permission-menu-group" style="margin-top: var(--space-2); <?= $is_checked ? '' : 'display: none;' ?>">
                                        <label class="form-label" style="font-size: var(--text-xs);">Menu Group</label>
                                        <select class="form-control form-select menu-group-select" 
                                                name="permissions[<?= esc($perm->permission_id) ?>]"
                                                data-permission-id="<?= esc($perm->permission_id) ?>">
                                            <option value="home" <?= $current_menu == 'home' ? 'selected' : '' ?>>Home</option>
                                            <option value="office" <?= $current_menu == 'office' ? 'selected' : '' ?>>Office</option>
                                            <option value="both" <?= $current_menu == 'both' ? 'selected' : '' ?>>Both</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <!-- Actions -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?= $is_new ? 'Create' : 'Update' ?> Role
                </button>
                
                <a href="<?= base_url('roles') ?>" class="btn btn-outline btn-block" style="margin-top: var(--space-3);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </button>
            </div>
        </div>
        
        <!-- Permission Summary -->
        <div class="card" style="margin-top: var(--space-6);">
            <div class="card-header">
                <h3 class="card-header-title">Permission Summary</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center;">
                    <div style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--primary-600);" id="selected_count">
                        <?= count($current_permissions) ?>
                    </div>
                    <div style="color: var(--text-secondary); font-size: var(--text-sm);">
                        Selected Permissions
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<style>
.permission-item {
    transition: all var(--transition-normal);
}

.permission-item:hover {
    border-color: var(--primary-400) !important;
}

.permission-checkbox:checked + span {
    color: var(--primary-700);
}
</style>

<script>
// Track permission selection
document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const permissionItem = this.closest('.permission-item');
        const menuGroup = permissionItem.querySelector('.permission-menu-group');
        
        if (this.checked) {
            permissionItem.style.background = 'var(--primary-50)';
            permissionItem.style.borderColor = 'var(--primary-300)';
            if (menuGroup) menuGroup.style.display = 'block';
        } else {
            permissionItem.style.background = '';
            permissionItem.style.borderColor = 'var(--border-primary)';
            if (menuGroup) menuGroup.style.display = 'none';
        }
        
        updatePermissionCount();
    });
});

// Disable menu group select when checkbox is unchecked
document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
    const permId = checkbox.getAttribute('data-permission-id');
    const select = document.querySelector(`.menu-group-select[data-permission-id="${permId}"]`);
    if (select && !checkbox.checked) {
        select.disabled = true;
    }
});

// Update menu group select disabled state on checkbox change
document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const permId = this.getAttribute('data-permission-id');
        const select = document.querySelector(`.menu-group-select[data-permission-id="${permId}"]`);
        if (select) {
            select.disabled = !this.checked;
        }
    });
});

function selectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
        checkbox.dispatchEvent(new Event('change'));
    });
}

function deselectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
        checkbox.dispatchEvent(new Event('change'));
    });
}

function updatePermissionCount() {
    const count = document.querySelectorAll('.permission-checkbox:checked').length;
    document.getElementById('selected_count').textContent = count;
}

// Form submission
document.getElementById('role_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    console.log('Form submit triggered');
    console.log('Form action:', this.action);
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving role...');
    }
    
    const formData = new FormData(this);
    
    // Log form data for debugging
    console.log('Form data entries:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (window.shopsuiteApp) {
                window.shopsuiteApp.hideLoading();
            }
            
            if (data.success) {
                if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
                    window.shopsuiteApp.showToast('Success', data.message || 'Role saved successfully', 'success');
                } else {
                    alert(data.message || 'Role saved successfully');
                }
                setTimeout(() => {
                    window.location.href = '<?= base_url("roles") ?>';
                }, 1000);
            } else {
                if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
                    window.shopsuiteApp.showToast('Error', data.message || 'Failed to save role', 'error');
                } else {
                    alert('Error: ' + (data.message || 'Failed to save role'));
                }
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response was:', text);
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
</script>

<?php echo view('layouts/modern_footer'); ?>
