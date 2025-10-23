# ShopSuite - AdminLTE 4 Gradual Migration Guide

## 🔐 Login Credentials

**Username:** `admin`  
**Password:** `admin123`

**Important:** Change this password after first login!

---

## 📋 Gradual Migration Strategy

This guide will help you migrate from Bootstrap 3 to AdminLTE 4 (Bootstrap 5) one module at a time.

---

## Phase 1: Home Module (Start Here)

### Step 1: Update Home Controller

Edit `app/Controllers/Home.php`:

```php
<?php
namespace App\Controllers;

class Home extends Secure_Controller
{
    public function index()
    {
        // Get allowed modules and user info
        $data = [
            'allowed_modules' => $this->module->get_allowed_modules($this->employee_id),
            'user_info' => $this->employee->get_info($this->employee_id),
            'config' => $this->config->get_all()
        ];
        
        // Use new AdminLTE view
        return view('home/home_adminlte', $data);
    }
}
```

### Step 2: Test Home Module

1. Login at http://localhost/
2. You should see the new AdminLTE 4 dashboard
3. Verify all module links work
4. Check responsive design on mobile

### Step 3: Rollback if Needed

If issues occur, change back to old view:
```php
return view('home/home', $data);
```

---

## Phase 2: Login Page

### Update Login Controller

Edit `app/Controllers/Login.php`:

Find the `index()` method and update the view:

```php
public function index()
{
    $data = [
        'config' => $this->config->get_all()
    ];
    
    // Use new AdminLTE login
    return view('login_adminlte', $data);
}
```

### Test Login Page

1. Logout
2. Visit http://localhost/
3. Verify new login page displays correctly
4. Test login functionality
5. Check "Remember Me" works

---

## Phase 3: Sales Module

### Step 1: Create AdminLTE Sales View

Create `app/Views/sales/manage_adminlte.php`:

```php
<?= view('layouts/adminlte_header', ['page_title' => lang('Module.sales')]) ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i>
                    <?= lang('Module.sales') ?>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" id="new-sale">
                        <i class="fas fa-plus"></i> <?= lang('Sales.new_sale') ?>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Your existing sales table/content here -->
                <?php // Copy content from original sales/manage.php ?>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/adminlte_footer') ?>
```

### Step 2: Update Sales Controller

Edit `app/Controllers/Sales.php`:

```php
public function index()
{
    // ... existing code ...
    
    // Use new AdminLTE view
    return view('sales/manage_adminlte', $data);
}
```

### Step 3: Test Sales Module

1. Navigate to Sales module
2. Test creating new sale
3. Test searching/filtering
4. Verify all buttons work
5. Check printing functionality

---

## Phase 4: Items Module

### Step 1: Create AdminLTE Items View

Create `app/Views/items/manage_adminlte.php`:

```php
<?= view('layouts/adminlte_header', ['page_title' => lang('Module.items')]) ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i>
                    <?= lang('Module.items') ?>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" id="new-item">
                        <i class="fas fa-plus"></i> <?= lang('Items.new') ?>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Bootstrap Table for items -->
                <table id="items-table" 
                       class="table table-striped table-hover"
                       data-toggle="table"
                       data-search="true"
                       data-pagination="true"
                       data-page-size="25">
                    <thead>
                        <tr>
                            <th data-field="item_id"><?= lang('Items.item_id') ?></th>
                            <th data-field="name"><?= lang('Items.name') ?></th>
                            <th data-field="category"><?= lang('Items.category') ?></th>
                            <th data-field="quantity"><?= lang('Items.quantity') ?></th>
                            <th data-field="price"><?= lang('Items.price') ?></th>
                            <th data-field="actions"><?= lang('Common.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Items data -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/adminlte_footer') ?>
```

### Step 2: Update Items Controller

Similar to Sales module.

---

## Phase 5: Customers Module

### Create AdminLTE Customers View

Create `app/Views/customers/manage_adminlte.php`:

```php
<?= view('layouts/adminlte_header', ['page_title' => lang('Module.customers')]) ?>

<div class="row">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i>
                    <?= lang('Module.customers') ?>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-light btn-sm" id="new-customer">
                        <i class="fas fa-user-plus"></i> <?= lang('Customers.new') ?>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Customer list/table -->
            </div>
        </div>
    </div>
</div>

<?= view('layouts/adminlte_footer') ?>
```

---

## Phase 6: Reports Module

### Create AdminLTE Reports View

Create `app/Views/reports/manage_adminlte.php`:

```php
<?= view('layouts/adminlte_header', ['page_title' => lang('Module.reports')]) ?>

<div class="row">
    <!-- Report Type Selection -->
    <div class="col-md-3">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    Report Types
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-dollar-sign"></i> Sales Summary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i> Inventory
                        </a>
                    </li>
                    <!-- More report types -->
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Report Content -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Report Results</h3>
            </div>
            <div class="card-body">
                <!-- Report content -->
            </div>
        </div>
    </div>
</div>

<?= view('layouts/adminlte_footer') ?>
```

---

## Phase 7: Configuration Module

### Create AdminLTE Config View

Create `app/Views/configs/manage_adminlte.php`:

```php
<?= view('layouts/adminlte_header', ['page_title' => lang('Module.config')]) ?>

<div class="row">
    <div class="col-12">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog"></i>
                    <?= lang('Module.config') ?>
                </h3>
            </div>
            <div class="card-body">
                <!-- Tabs for different config sections -->
                <ul class="nav nav-tabs" id="config-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general">
                            <i class="fas fa-info-circle"></i> General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#locale">
                            <i class="fas fa-globe"></i> Locale
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#receipt">
                            <i class="fas fa-receipt"></i> Receipt
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="general">
                        <!-- General settings form -->
                    </div>
                    <div class="tab-pane fade" id="locale">
                        <!-- Locale settings form -->
                    </div>
                    <div class="tab-pane fade" id="receipt">
                        <!-- Receipt settings form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/adminlte_footer') ?>
```

---

## Migration Checklist

### Before Each Module Migration

- [ ] Backup current controller file
- [ ] Create new AdminLTE view file
- [ ] Test in development environment
- [ ] Verify all functionality works
- [ ] Check responsive design
- [ ] Test with different user permissions

### After Each Module Migration

- [ ] Update any related JavaScript files
- [ ] Update CSS if needed
- [ ] Test integration with other modules
- [ ] Document any issues
- [ ] Commit changes to git

---

## Testing Checklist

### For Each Migrated Module

- [ ] Page loads without errors
- [ ] All buttons work correctly
- [ ] Forms submit properly
- [ ] Tables display data
- [ ] Search/filter functions work
- [ ] Modals/dialogs open correctly
- [ ] Print functionality works
- [ ] Export features work
- [ ] Mobile responsive
- [ ] No console errors

---

## Common Issues & Solutions

### Issue: JavaScript not working

**Solution:** Update script paths in footer:
```php
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
```

### Issue: Styles broken

**Solution:** Check CSS order in header:
```php
<link rel="stylesheet" href="node_modules/admin-lte/dist/css/adminlte.min.css">
```

### Issue: Modals not displaying

**Solution:** Ensure Bootstrap 5 modal syntax:
```javascript
var myModal = new bootstrap.Modal(document.getElementById('myModal'));
myModal.show();
```

### Issue: Tables not rendering

**Solution:** Initialize Bootstrap Table:
```javascript
$('#table').bootstrapTable({
    // options
});
```

---

## Module Migration Order (Recommended)

1. ✅ **Home** - Dashboard (Start here)
2. ✅ **Login** - Login page
3. **Sales** - Most used module
4. **Items** - Inventory management
5. **Customers** - Customer management
6. **Receivings** - Stock receiving
7. **Reports** - Reporting
8. **Employees** - User management
9. **Config** - Settings
10. **Other modules** - Remaining modules

---

## Quick Reference: View Conversion

### Old Bootstrap 3 View
```php
<?= view('partial/header') ?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body">
            Content
        </div>
    </div>
</div>
<?= view('partial/footer') ?>
```

### New AdminLTE 4 View
```php
<?= view('layouts/adminlte_header', ['page_title' => 'Title']) ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Title</h3>
            </div>
            <div class="card-body">
                Content
            </div>
        </div>
    </div>
</div>
<?= view('layouts/adminlte_footer') ?>
```

---

## Bootstrap 3 to 5 Component Changes

### Panels → Cards
```html
<!-- Old -->
<div class="panel panel-default">
    <div class="panel-heading">Title</div>
    <div class="panel-body">Content</div>
</div>

<!-- New -->
<div class="card">
    <div class="card-header">Title</div>
    <div class="card-body">Content</div>
</div>
```

### Buttons
```html
<!-- Old -->
<button class="btn btn-default">Button</button>

<!-- New -->
<button class="btn btn-secondary">Button</button>
```

### Forms
```html
<!-- Old -->
<div class="form-group">
    <label>Label</label>
    <input type="text" class="form-control">
</div>

<!-- New -->
<div class="mb-3">
    <label class="form-label">Label</label>
    <input type="text" class="form-control">
</div>
```

---

## Support & Resources

- **AdminLTE 4 Docs:** https://adminlte.io/docs/4.0/
- **Bootstrap 5 Docs:** https://getbootstrap.com/docs/5.3/
- **Migration Issues:** Check `writable/logs/` for errors

---

## Final Notes

- Take your time with each module
- Test thoroughly before moving to next module
- Keep old views as backup
- Document any custom changes
- Update this guide as you discover new patterns

**Good luck with your migration!** 🚀
