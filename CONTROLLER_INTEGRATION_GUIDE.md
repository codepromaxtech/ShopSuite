# 🔧 Controller Integration Guide

## Quick Guide to Integrate New Bootstrap 5 Views

---

## 📋 Overview

All new Bootstrap 5 views are ready. Now we need to update controllers to use them.

---

## 🎯 Simple 3-Step Process

### Step 1: Find the Controller
### Step 2: Find the manage() or index() method
### Step 3: Change the view name

---

## 📝 Module-by-Module Guide

### 1. Sales Module

**File:** `app/Controllers/Sales.php`

**Find this:**
```php
return view('sales/manage', $data);
```

**Change to:**
```php
return view('sales/manage_bootstrap5', $data);
```

---

### 2. Items Module

**File:** `app/Controllers/Items.php`

**Find this:**
```php
return view('items/manage', $data);
```

**Change to:**
```php
return view('items/manage_bootstrap5', $data);
```

---

### 3. Customers Module

**File:** `app/Controllers/Customers.php`

**Find this:**
```php
return view('customers/manage', $data);
```

**Change to:**
```php
return view('customers/manage_bootstrap5', $data);
```

---

### 4. Reports Module

**File:** `app/Controllers/Reports.php`

**Find this:**
```php
return view('reports/manage', $data);
```

**Change to:**
```php
return view('reports/manage_bootstrap5', $data);
```

---

### 5. Suppliers Module

**File:** `app/Controllers/Suppliers.php`

**Find this:**
```php
return view('suppliers/manage', $data);
```

**Change to:**
```php
return view('suppliers/manage_bootstrap5', $data);
```

---

### 6. Employees Module

**File:** `app/Controllers/Employees.php`

**Find this:**
```php
return view('employees/manage', $data);
```

**Change to:**
```php
return view('employees/manage_bootstrap5', $data);
```

---

### 7. Receivings Module

**File:** `app/Controllers/Receivings.php`

**Find this:**
```php
return view('receivings/manage', $data);
```

**Change to:**
```php
return view('receivings/manage_bootstrap5', $data);
```

---

### 8. Config Module

**File:** `app/Controllers/Config.php`

**Find this:**
```php
return view('config/manage', $data);
```

**Change to:**
```php
return view('config/manage_bootstrap5', $data);
```

---

### 9. Giftcards Module

**File:** `app/Controllers/Giftcards.php`

**Find this:**
```php
return view('giftcards/manage', $data);
```

**Change to:**
```php
return view('giftcards/manage_bootstrap5', $data);
```

---

## 🔍 Finding the Right Method

Most controllers have a method like:
- `manage()`
- `index()`
- `getIndex()`

Look for the method that displays the main list/management page.

---

## 📦 Required Data

Each view expects these data variables:

```php
$data = [
    'allowed_modules' => $this->module->get_allowed_modules($this->employee_id),
    'user_info' => $this->employee->get_info($this->employee_id),
    'config' => $this->config->get_all()
];
```

Make sure your controller passes these!

---

## ✅ Testing Checklist

After updating each controller:

1. ✅ Clear PHP cache: `sudo systemctl restart php8.3-fpm`
2. ✅ Visit the module URL
3. ✅ Check if new UI loads
4. ✅ Test search functionality
5. ✅ Test responsive design
6. ✅ Check for errors in logs

---

## 🚀 Quick Command

Clear cache after changes:
```bash
sudo systemctl restart php8.3-fpm
```

---

## 🐛 Troubleshooting

### View Not Found Error
- Check file path is correct
- Ensure file exists in `app/Views/[module]/`
- Verify file name ends with `_bootstrap5.php`

### Missing Data Error
- Ensure controller passes required data
- Check `allowed_modules`, `user_info`, `config` are set

### Styling Issues
- Clear browser cache (Ctrl+Shift+R)
- Check CDN links are loading
- Verify Bootstrap 5 CSS is included

---

## 📊 Progress Tracking

Use this checklist:

```
Controllers to Update:

[ ] Sales
[ ] Items
[ ] Customers
[ ] Reports
[ ] Suppliers
[ ] Employees
[ ] Receivings
[ ] Config
[ ] Giftcards
```

---

## 💡 Pro Tips

1. **Update one at a time** - Test each before moving to next
2. **Keep old views** - Don't delete until new ones work
3. **Test thoroughly** - Check all functionality
4. **Clear cache often** - PHP caches views
5. **Check logs** - Look for errors in `writable/logs/`

---

## 🎯 Example: Complete Controller Update

```php
<?php
namespace App\Controllers;

class Sales extends Secure_Controller
{
    public function manage()
    {
        // Prepare data
        $data = [
            'allowed_modules' => $this->module->get_allowed_modules($this->employee_id),
            'user_info' => $this->employee->get_info($this->employee_id),
            'config' => $this->config->get_all()
        ];
        
        // Use new Bootstrap 5 view
        return view('sales/manage_bootstrap5', $data);
    }
}
```

---

## 🌐 Test URLs

After updating controllers, test these URLs:

- http://localhost/sales
- http://localhost/items
- http://localhost/customers
- http://localhost/reports
- http://localhost/suppliers
- http://localhost/employees
- http://localhost/receivings
- http://localhost/config
- http://localhost/giftcards

---

## ✅ Success!

When done correctly, you'll see:
- ✅ Modern Bootstrap 5 UI
- ✅ Stats dashboards
- ✅ Clean card layouts
- ✅ Responsive design
- ✅ Professional appearance

---

**Ready to integrate?** Start with Sales module and work your way through the list! 🚀
