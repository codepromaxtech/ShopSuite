# 🎨 CSS Not Loading - Fix Guide

## 🔍 Issue
Bootstrap 5 CSS and JavaScript not loading on sales and other modules.

---

## ✅ Quick Fixes (Try These First)

### 1. **Hard Refresh Browser** ⭐ MOST COMMON FIX
```
Windows/Linux: Ctrl + Shift + R
Mac: Cmd + Shift + R
```

### 2. **Clear Browser Cache**
- Chrome: Settings → Privacy → Clear browsing data → Cached images and files
- Firefox: Settings → Privacy & Security → Clear Data
- Or use Incognito/Private mode

### 3. **Check Console for Errors**
Press `F12` to open Developer Tools, then check:
- **Console tab**: Look for errors (red text)
- **Network tab**: Look for failed requests (red)

---

## 🔧 Technical Fixes

### Issue 1: CDN Blocked (No Internet)
**Symptom:** Page loads but looks plain, no styling
**Cause:** Bootstrap 5 loads from CDN (cdn.jsdelivr.net)

**Solution:** Check if you can access:
```
https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css
```

If blocked, you need to:
1. **Enable Internet** OR
2. **Download Bootstrap locally**

### Issue 2: Old Views Still Loading
**Symptom:** Some modules look new, others look old

**Solution:**
```bash
cd /home/erp/ShopSuite
rm -rf writable/cache/*
sudo systemctl restart php8.3-fpm nginx
```

### Issue 3: Mixed Content (HTTP/HTTPS)
**Symptom:** Console shows "Mixed Content" errors

**Solution:** All CDN links in header use HTTPS ✅

---

## 🧪 Test Each Module

### Current URLs:
- **Home:** http://localhost/home
- **Sales:** http://localhost/sales  
- **Items:** http://localhost/items
- **Customers:** http://localhost/customers
- **Suppliers:** http://localhost/suppliers
- **Reports:** http://localhost/reports
- **Config:** http://localhost/config
- **Giftcards:** http://localhost/giftcards

---

## 📋 Checklist

### For Each Module That Has No CSS:

- [ ] Hard refresh (Ctrl + Shift + R)
- [ ] Check F12 Console for errors
- [ ] Check F12 Network tab
- [ ] Look for red/failed requests
- [ ] Note which files failed to load

### Common Errors:

#### ❌ "Failed to load resource: net::ERR_INTERNET_DISCONNECTED"
**Fix:** Connect to internet

#### ❌ "Failed to load resource: 404 Not Found"
**Fix:** File path wrong, check base URL

#### ❌ "Refused to apply style... MIME type"
**Fix:** Server configuration issue

---

## 🔍 Debug Information

### Check What's Actually Loading:

**In Browser Console (F12), run:**
```javascript
// Check if Bootstrap CSS loaded
console.log(getComputedStyle(document.body).fontFamily);
// Should show: "Inter", sans-serif

// Check if jQuery loaded
console.log(typeof jQuery);
// Should show: "function"

// Check if Bootstrap JS loaded
console.log(typeof bootstrap);
// Should show: "object"
```

---

## 💡 Most Likely Causes

### 1. **Browser Cache** (90% of cases)
Solution: Ctrl + Shift + R

### 2. **No Internet Connection** (8% of cases)
Solution: Connect to internet or install Bootstrap locally

### 3. **Wrong View Loading** (2% of cases)
Solution: Verify controller is using `*_bootstrap5.php` view

---

## 🔧 Verify Controllers Are Using Bootstrap 5

Run this command to check:
```bash
cd /home/erp/ShopSuite
grep -r "bootstrap5" app/Controllers/*.php
```

**Expected output:**
```
app/Controllers/Sales.php:echo view('sales/manage_bootstrap5', $data);
app/Controllers/Items.php:echo view('items/manage_bootstrap5', $data);
app/Controllers/Customers.php:echo view('customers/manage_bootstrap5', $data);
app/Controllers/Suppliers.php:echo view('suppliers/manage_bootstrap5', $data);
app/Controllers/Reports.php:echo view('reports/manage_bootstrap5', $data);
app/Controllers/Config.php:echo view('config/manage_bootstrap5', $data);
app/Controllers/Giftcards.php:echo view('giftcards/manage_bootstrap5', $data);
app/Controllers/Home.php:echo view('home/home_bootstrap5', $data);
```

---

## 🌐 Check If CDNs Are Accessible

Test in terminal:
```bash
# Test Bootstrap CSS
curl -I https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css

# Test Bootstrap Icons
curl -I https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css

# Test jQuery
curl -I https://code.jquery.com/jquery-3.7.1.min.js
```

**All should return:** `HTTP/2 200`

---

## 🔄 Full Reset (If Nothing Else Works)

```bash
cd /home/erp/ShopSuite

# Clear all caches
rm -rf writable/cache/*
rm -rf writable/session/*

# Fix permissions
sudo chown -R www-data:www-data writable/
sudo chmod -R 775 writable/
sudo chmod -R 777 writable/cache writable/logs writable/session

# Restart services
sudo systemctl restart php8.3-fpm nginx

# Clear browser cache and hard refresh
```

---

## 📞 Screenshot Your F12 Console

If CSS still not loading:

1. Press `F12` in browser
2. Go to **Console** tab
3. Take screenshot
4. Go to **Network** tab  
5. Take screenshot
6. Share screenshots for debugging

---

## ✅ What Should Work

If everything is correct, you should see:
- ✅ Modern dark sidebar
- ✅ Clean white content area
- ✅ Bootstrap icons (bi-*)
- ✅ Professional fonts (Inter)
- ✅ Smooth shadows and borders
- ✅ Responsive design

---

**Date:** 2025-10-23  
**Status:** Troubleshooting Guide  
**Priority:** HIGH
