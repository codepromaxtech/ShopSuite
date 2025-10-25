<?php
/**
 * MODERN ROLES & PERMISSIONS PAGE
 */
$title = 'Roles & Permissions';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-shield-lock me-2"></i>
                Roles & Permissions
            </h3>
            <small class="text-muted">Manage user roles and module access permissions</small>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('roles/view/-1', 'Create New Role')">
                <i class="bi bi-plus-circle me-1"></i>Create Role
            </button>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="row g-4">
        <?php foreach ($roles as $role): ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 role-card <?= $role->is_system_role ? 'border-primary' : '' ?>" data-role-id="<?= $role->role_id ?>">
                    <?php if ($role->is_system_role): ?>
                        <div class="card-header bg-primary text-white py-2">
                            <small><i class="bi bi-shield-check me-1"></i>System Role</small>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?= esc($role->role_name) ?></h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="openModal('roles/view/<?= $role->role_id ?>', 'Edit Role'); return false;">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="duplicateRole(<?= $role->role_id ?>, '<?= esc($role->role_name) ?>'); return false;">
                                            <i class="bi bi-files me-2"></i>Duplicate
                                        </a>
                                    </li>
                                    <?php if (!$role->is_system_role): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="deleteRole(<?= $role->role_id ?>); return false;">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted small mb-3">
                            <?= esc($role->role_description) ?>
                        </p>
                        
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <div class="text-muted small">Permissions</div>
                                <div class="fw-bold"><?= $role->permission_count ?></div>
                            </div>
                            <div>
                                <div class="text-muted small">Users</div>
                                <div class="fw-bold"><?= $role->employee_count ?></div>
                            </div>
                        </div>
                        
                        <button class="btn btn-sm btn-outline-primary w-100" onclick="openModal('roles/view/<?= $role->role_id ?>', 'Manage Permissions')">
                            <i class="bi bi-key me-1"></i>Manage Permissions
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($roles)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No roles found. Click "Create Role" to add your first role.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.role-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.role-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.role-card.border-primary {
    border-width: 2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🛡️ Roles Management Page Loaded');
});

function deleteRole(roleId) {
    Swal.fire({
        title: 'Delete Role?',
        text: 'This action cannot be undone. Make sure no employees are assigned to this role.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'roles/delete',
                method: 'POST',
                data: { ids: [roleId] },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        location.reload();
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred', 'error');
                }
            });
        }
    });
}

function duplicateRole(roleId, roleName) {
    Swal.fire({
        title: 'Duplicate Role',
        input: 'text',
        inputLabel: 'Enter name for the duplicated role',
        inputValue: roleName + ' (Copy)',
        showCancelButton: true,
        confirmButtonText: 'Duplicate',
        inputValidator: (value) => {
            if (!value) {
                return 'Please enter a role name';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'roles/duplicate',
                method: 'POST',
                data: { 
                    role_id: roleId,
                    new_name: result.value
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        location.reload();
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred', 'error');
                }
            });
        }
    });
}
</script>

<?= view('layouts/modern_footer') ?>
