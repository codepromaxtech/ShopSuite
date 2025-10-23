# ShopSuite - Troubleshooting Guide

## ✅ Fixed Issues

### Issue 1: CSS Files Not Loading ✅ FIXED

**Problem:** CSS files from `node_modules` were not accessible, causing unstyled login page.

**Root Cause:** 
- `node_modules` directory was empty (npm install didn't complete)
- Files referenced from `node_modules` but not in public directory

**Solution Applied:**
- Updated all views to use CDN links instead of local node_modules
- Files now load from:
  - Font Awesome: `cdnjs.cloudflare.com`
  - Bootstrap 5: `cdn.jsdelivr.net`
  - AdminLTE 4: `cdn.jsdelivr.net`
  - jQuery: `code.jquery.com`

**Files Modified:**
- `app/Views/login_adminlte.php`
- `app/Views/layouts/adminlte_header.php`
- `app/Views/layouts/adminlte_footer.php`

**Status:** ✅ Fixed - CSS now loads properly

---

### Issue 2: Login Redirect Loop ⚠️ INVESTIGATING

**Problem:** After entering credentials, page reloads back to login.

**Possible Causes:**

1. **Session Configuration**
   - Check if sessions are working
   - Verify session directory is writable

2. **Database Connection**
   - Verify employee record exists
   - Check password hash is correct

3. **Validation Rules**
   - Check login_check validation
   - Verify password verification

**Current Status:**
- ✅ Database: Connected
- ✅ User exists: admin (person_id: 1)
- ✅ Password hash: Set correctly
- ⚠️ Session: Needs verification

---

## 🔍 Diagnostic Steps

### Test 1: Check Session Configuration

```bash
# Check writable directory permissions
ls -la writable/session/

# Should show:
# drwxr-xr-x www-data:www-data
```

**Fix if needed:**
```bash
sudo chown -R www-data:www-data writable/session/
sudo chmod -R 775 writable/session/
```

### Test 2: Check Database Connection

```bash
mysql -u shopsuite -pshopsuite@2024 shopsuite -e "SELECT username, person_id FROM shopsuite_employees WHERE username = 'admin';"
```

**Expected Output:**
```
username | person_id
admin    | 1
```

### Test 3: Test Password Hash

```bash
php -r "echo password_verify('admin123', '\$2y\$10\$p9RxurlQO.3mRBfz5cKVjutdn2SPHgQ2r2uAeFbRpaedxF5BEmidO') ? 'PASS' : 'FAIL';"
```

**Expected:** PASS

### Test 4: Check Application Logs

```bash
tail -f writable/logs/log-*.log
```

Look for errors during login attempt.

### Test 5: Check PHP Error Logs

```bash
sudo tail -f /var/log/php8.3-fpm.log
```

### Test 6: Check Nginx Error Logs

```bash
sudo tail -f /var/log/nginx/shopsuite_error.log
```

---

## 🔧 Common Fixes

### Fix 1: Reset Session Directory

```bash
cd /home/erp/ShopSuite
sudo rm -rf writable/session/*
sudo chown -R www-data:www-data writable/session/
sudo chmod -R 775 writable/session/
sudo systemctl restart php8.3-fpm
```

### Fix 2: Clear Application Cache

```bash
cd /home/erp/ShopSuite
sudo rm -rf writable/cache/*
sudo chown -R www-data:www-data writable/cache/
sudo chmod -R 775 writable/cache/
```

### Fix 3: Verify .env Configuration

Check `/home/erp/ShopSuite/.env`:

```ini
CI_ENVIRONMENT = development
CI_DEBUG = true

database.default.hostname = 'localhost'
database.default.database = 'shopsuite'
database.default.username = 'shopsuite'
database.default.password = 'shopsuite@2024'
database.default.DBPrefix = 'shopsuite_'
```

### Fix 4: Restart All Services

```bash
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
sudo systemctl restart mariadb
```

### Fix 5: Check Base URL

Edit `app/Config/App.php` or `.env`:

```php
public string $baseURL = 'http://localhost/';
```

Or in `.env`:
```ini
app.baseURL = 'http://localhost/'
```

---

## 🐛 Debug Mode

### Enable Debug Mode

Edit `.env`:
```ini
CI_ENVIRONMENT = development
CI_DEBUG = true
```

### View Debug Information

Add to `.env`:
```ini
logger.threshold = 9
```

Then check logs:
```bash
tail -f writable/logs/log-*.log
```

---

## 📝 Login Issue Checklist

When login redirects back to login page, check:

- [ ] Session directory writable (`writable/session/`)
- [ ] Cache directory writable (`writable/cache/`)
- [ ] Database connection working
- [ ] User exists in database
- [ ] Password hash is correct
- [ ] Base URL is correct in config
- [ ] PHP sessions enabled
- [ ] Cookie settings correct
- [ ] No JavaScript errors in browser console
- [ ] CSRF token working
- [ ] Validation rules passing

---

## 🔐 Security Checks

### Check File Permissions

```bash
# Writable directories
ls -la writable/
ls -la writable/session/
ls -la writable/cache/
ls -la writable/logs/
ls -la public/uploads/

# Should all be: drwxrwxr-x www-data:www-data
```

### Check .env File

```bash
ls -la .env
# Should be: -rw-r--r-- erp:erp
```

---

## 🌐 Browser Console Errors

### Check for JavaScript Errors

1. Open browser (F12)
2. Go to Console tab
3. Try to login
4. Look for errors

**Common Errors:**
- `Failed to load resource` - Check CDN links
- `CSRF token mismatch` - Clear cookies
- `Session expired` - Check session config

---

## 📊 Performance Issues

### Slow Page Load

**Check:**
```bash
curl -o /dev/null -s -w "Time: %{time_total}s\n" http://localhost/
```

**Should be:** < 1 second

**If slow:**
- Check database queries
- Enable OPcache
- Check server resources

### High Memory Usage

```bash
free -h
```

**Fix:**
- Restart PHP-FPM
- Check for memory leaks
- Optimize database queries

---

## 🔄 Reset Everything

### Nuclear Option - Complete Reset

```bash
cd /home/erp/ShopSuite

# Clear all caches
sudo rm -rf writable/cache/*
sudo rm -rf writable/session/*
sudo rm -rf writable/logs/*

# Reset permissions
sudo chown -R www-data:www-data writable/
sudo chmod -R 775 writable/
sudo chown -R www-data:www-data public/uploads/
sudo chmod -R 775 public/uploads/

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
sudo systemctl restart mariadb

# Clear browser cache and cookies
# Then try login again
```

---

## 📞 Getting Help

### Collect Debug Information

```bash
# System info
uname -a
php -v
nginx -v
mysql --version

# Service status
sudo systemctl status nginx
sudo systemctl status php8.3-fpm
sudo systemctl status mariadb

# Recent errors
sudo tail -50 /var/log/nginx/shopsuite_error.log
sudo tail -50 /var/log/php8.3-fpm.log
tail -50 writable/logs/log-*.log

# Permissions
ls -la writable/
ls -la public/
```

### Test URLs

```bash
# Homepage
curl -I http://localhost/

# Login page
curl -I http://localhost/login

# Test with verbose
curl -v http://localhost/ 2>&1 | grep -i "set-cookie"
```

---

## ✅ Success Indicators

When everything is working:

- ✅ Login page loads with proper styling
- ✅ CSS and JavaScript load without errors
- ✅ Can enter username and password
- ✅ Login redirects to dashboard (not back to login)
- ✅ Dashboard shows all modules
- ✅ Sidebar navigation works
- ✅ User dropdown functions
- ✅ No errors in browser console
- ✅ No errors in server logs

---

**Last Updated:** 2025-10-23 21:50  
**Status:** CSS Fixed ✅ | Login Issue Under Investigation ⚠️
