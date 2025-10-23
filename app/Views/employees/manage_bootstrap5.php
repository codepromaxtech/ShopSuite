<?php
/**
 * Modern Bootstrap 5 Employees Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.employees'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.employees'),
    'subtitle' => 'Manage staff and permissions',
    'icon' => 'bi-person-badge',
    'actions' => [
        [
            'label' => 'Add Employee',
            'url' => base_url('employees/view/-1'),
            'color' => 'primary',
            'icon' => 'bi-person-plus',
            'size' => 'btn-lg'
        ]
    ]
]) ?>

<!-- Employee Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Employees</p>
                        <h4 class="mb-0 fw-bold text-primary">0</h4>
                    </div>
                    <i class="bi bi-people fs-1 text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Active Today</p>
                        <h4 class="mb-0 fw-bold text-success">0</h4>
                    </div>
                    <i class="bi bi-person-check fs-1 text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Sales</p>
                        <h4 class="mb-0 fw-bold text-warning">$0.00</h4>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-info bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Avg. Performance</p>
                        <h4 class="mb-0 fw-bold text-info">0%</h4>
                    </div>
                    <i class="bi bi-graph-up fs-1 text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employees Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Employee List
                </h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           placeholder="Search employees...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" 
                   id="employees-table"
                   data-toggle="table"
                   data-search="true"
                   data-pagination="true"
                   data-page-size="25">
                <thead class="table-light">
                    <tr>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="username">Username</th>
                        <th data-field="email">Email</th>
                        <th data-field="phone">Phone</th>
                        <th data-field="role">Role</th>
                        <th data-field="status">Status</th>
                        <th data-field="last_login">Last Login</th>
                        <th data-field="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-person-badge fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No employees in system</p>
                            <a href="<?= base_url('employees/view/-1') ?>" class="btn btn-primary mt-3">
                                <i class="bi bi-person-plus me-2"></i>
                                Add First Employee
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#employees-table').bootstrapTable();
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
