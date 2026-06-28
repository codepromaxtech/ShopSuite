<?php
$title = (isset($person_info) && $person_info->person_id > 0) ? 'Edit Employee - ShopSuite' : 'Add Employee - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);

$is_edit = isset($person_info) && $person_info->person_id > 0;
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            <div>
                <h1><?= $is_edit ? 'Edit Employee' : 'Add New Employee' ?></h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('employees') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('employees') ?>">Employees</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></div>
    </div>
</div>

<form id="employeeForm" method="post" action="<?= base_url('employees/save/' . ($person_info->person_id ?? -1)) ?>">
    <?= csrf_field() ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card u-margin-bottom-space-6">
                <div class="card-header">
                    <h3 class="card-header-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="first_name" class="form-label form-label-required">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= esc($person_info->first_name ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name" class="form-label form-label-required">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= esc($person_info->last_name ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($person_info->email ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?= esc($person_info->phone_number ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card u-margin-bottom-space-6">
                <div class="card-header">
                    <h3 class="card-header-title">Login Credentials</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="username" class="form-label form-label-required">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= esc($person_info->username ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label <?= !$is_edit ? 'form-label-required' : '' ?>">Password</label>
                            <input type="password" class="form-control" id="password" name="password" <?= !$is_edit ? 'required minlength="8"' : 'minlength="8"' ?>>
                            <?php if ($is_edit): ?>
                                <span class="form-help">Leave blank to keep current password</span>
                            <?php else: ?>
                                <span class="form-help">Minimum 8 characters</span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($roles)): ?>
                        <div class="form-group sm:col-span-2">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-control form-select" id="role_id" name="role_id" onchange="document.getElementById('sync_role_grants').checked = true;">
                                <option value="">— Custom permissions —</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= (int) $role->role_id ?>" <?= (isset($selected_role_id) && (int) $selected_role_id === (int) $role->role_id) ? 'selected' : '' ?>>
                                        <?= esc($role->role_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label class="form-check u-margin-top-space-2">
                                <input type="checkbox" class="form-check-input" id="sync_role_grants" name="sync_role_grants" value="1" checked>
                                <span class="form-check-label">Apply role permissions on save</span>
                            </label>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Module Permissions</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php if (isset($all_modules)): ?>
                            <?php foreach ($all_modules as $module): ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="grant_<?= esc($module->module_id) ?>" name="grants[]" value="<?= esc($module->module_id) ?>" <?= $module->grant ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="grant_<?= esc($module->module_id) ?>">
                                        <?= esc($module->name_lang_key) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?= $is_edit ? 'Update Employee' : 'Save Employee' ?>
                    </button>
                    
                    <a href="<?= base_url('employees') ?>" class="btn btn-outline btn-block mt-space-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <?php if ($is_edit): ?>
                        <button type="button" class="btn btn-danger btn-block u-margin-top-space-3" onclick="deleteEmployee()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Employee
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('employeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving employee...');
    }
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }
        
        if (data.success) {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Success', 'Employee saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("employees") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save employee', 'error');
            }
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
            window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
        }
        console.error('Error:', error);
    });
});

function deleteEmployee() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Employee',
            'Are you sure you want to delete this employee? This action cannot be undone.',
            function() {
                window.location.href = '<?= base_url("employees/delete/" . ($person_info->person_id ?? "")) ?>';
            }
        );
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
