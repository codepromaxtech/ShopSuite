<?php
/**
 * Modern Bootstrap 5 Items Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.items'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.items'),
    'subtitle' => 'Manage products and inventory',
    'icon' => 'bi-box-seam',
    'actions' => [
        [
            'label' => 'Add Product',
            'url' => base_url('items/view/-1'),
            'color' => 'primary',
            'icon' => 'bi-plus-circle',
            'size' => 'btn-lg'
        ],
        [
            'label' => 'Import',
            'url' => base_url('items/import'),
            'color' => 'secondary',
            'icon' => 'bi-upload'
        ]
    ]
]) ?>

<!-- Inventory Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Products</p>
                        <h4 class="mb-0 fw-bold text-primary">0</h4>
                    </div>
                    <i class="bi bi-box-seam fs-1 text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">In Stock</p>
                        <h4 class="mb-0 fw-bold text-success">0</h4>
                    </div>
                    <i class="bi bi-check-circle fs-1 text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Low Stock</p>
                        <h4 class="mb-0 fw-bold text-warning">0</h4>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-danger bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Out of Stock</p>
                        <h4 class="mb-0 fw-bold text-danger">0</h4>
                    </div>
                    <i class="bi bi-x-circle fs-1 text-danger opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#all">
                    <i class="bi bi-grid me-2"></i>All Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#in-stock">
                    <i class="bi bi-check-circle me-2"></i>In Stock
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#low-stock">
                    <i class="bi bi-exclamation-triangle me-2"></i>Low Stock
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#out-stock">
                    <i class="bi bi-x-circle me-2"></i>Out of Stock
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Products Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Product List
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
                           placeholder="Search products...">
                    <select class="form-select" style="max-width: 200px;">
                        <option>All Categories</option>
                        <option>Electronics</option>
                        <option>Clothing</option>
                        <option>Food</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" 
                   id="items-table"
                   data-toggle="table"
                   data-search="true"
                   data-pagination="true"
                   data-page-size="25">
                <thead class="table-light">
                    <tr>
                        <th data-field="image">Image</th>
                        <th data-field="name" data-sortable="true">Product Name</th>
                        <th data-field="category" data-sortable="true">Category</th>
                        <th data-field="sku">SKU</th>
                        <th data-field="price" data-sortable="true">Price</th>
                        <th data-field="stock" data-sortable="true">Stock</th>
                        <th data-field="status">Status</th>
                        <th data-field="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No products in inventory</p>
                            <a href="<?= base_url('items/view/-1') ?>" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add First Product
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.nav-pills .nav-link {
    color: #6c757d;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
}
</style>

<script>
$(document).ready(function() {
    $('#items-table').bootstrapTable();
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
