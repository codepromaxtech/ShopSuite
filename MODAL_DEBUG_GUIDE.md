# Modal Debugging Guide

## Testing Modal Content Loading

### Step 1: Test URL Directly

Before testing in the modal, test the URL directly in your browser:

1. Go to: `http://your-site.com/customers/view`
2. You should see the form HTML
3. Check if all fields are visible

If the form doesn't display properly when accessed directly, the modal won't work either.

### Step 2: Check Console Logs

When you click "New Customer", check the browser console (F12):

**Expected logs:**
```
🔄 Loading modal content from: /customers/view
✅ Content loaded, length: XXXX
📋 Form found: Yes
📝 Form fields found: XX
  Field 1: text - first_name
  Field 2: text - last_name
  Field 3: email - email
  ...
📦 Found X scripts to execute
✅ Executed script 1
✅ Modal opened successfully
```

### Step 3: Common Issues

#### Issue: "Content loaded, length: 0" or very small
**Problem:** Server returned empty or error response
**Solution:** 
- Check if route `/customers/view` exists
- Check if controller method exists
- Check server logs for errors

#### Issue: "Form found: No"
**Problem:** HTML doesn't contain a `<form>` tag
**Solution:**
- Check if the view file has a proper form
- Use `/customers/form_bootstrap5` view instead of old `form`

#### Issue: "Form fields found: 0"
**Problem:** Form exists but has no input fields
**Solution:**
- Check if form content is properly rendered
- Check for PHP errors in the view file
- Ensure all variables are passed to the view

### Step 4: Network Tab Check

1. Open browser DevTools (F12)
2. Go to Network tab
3. Click "New Customer"
4. Find the request to `/customers/view`
5. Check:
   - Status: Should be 200
   - Response tab: Should show HTML with form fields
   - Size: Should be > 1KB

### Step 5: Create Test Endpoint

Create a simple test endpoint to verify modal system works:

In your controller, add:
```php
public function modalTest()
{
    return view('test_modal_content');
}
```

Create `/app/Views/test_modal_content.php`:
```php
<h3>Modal Test</h3>
<form id="test-form">
    <div class="mb-3">
        <label for="test-name" class="form-label">Name</label>
        <input type="text" class="form-control" id="test-name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="test-email" class="form-label">Email</label>
        <input type="email" class="form-control" id="test-email" name="email" required>
    </div>
</form>
```

Then test with:
```html
<button class="btn btn-primary modal-dlg" data-href="/customers/modalTest" title="Test Modal">
    Test Modal
</button>
```

If this works, the modal system is fine. The problem is with the actual form view.

### Step 6: Ensure Bootstrap 5 Form is Used

Make sure your controller uses the Bootstrap 5 form:

```php
public function view($person_id = -1)
{
    $person_info = $person_id > 0 
        ? $this->person->get_info($person_id) 
        : $this->person->get_empty_object();
    
    $data = [
        'person_info' => $person_info,
        'controller_name' => 'customers',
        'config' => $this->config->get_all(),
        'stats' => []
    ];
    
    // Use Bootstrap 5 form
    return view('customers/form_bootstrap5', $data);
}
```

## Quick Fixes

### Fix 1: Update Button to Use Bootstrap 5 Form
```html
<button class="btn btn-primary" onclick="openModal('/customers/view', 'New Customer', {size: 'xl'})">
    <i class="bi bi-person-plus me-2"></i>New Customer
</button>
```

### Fix 2: Check if Form View Has All Required Variables

The form expects:
- `$person_info` (object)
- `$controller_name` (string)
- `$config` (array)
- `$stats` (array, optional)

### Fix 3: Verify Server Response

Use curl to test:
```bash
curl -i http://your-site.com/customers/view
```

Should return HTML with status 200.

## Still Not Working?

Share with me:
1. Console logs (all lines starting with 🔄, ✅, 📋, etc.)
2. Network tab screenshot showing the request
3. What you see in the modal (empty? error? something else?)
4. Direct URL test result (does `/customers/view` work in browser?)
