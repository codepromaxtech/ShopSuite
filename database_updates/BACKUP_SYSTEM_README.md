# 💾 DATABASE BACKUP SYSTEM

## Overview

A complete database backup and restore system with:
- Manual backup creation
- Download backups
- Restore from backups
- Delete old backups
- **Automatic scheduled backups**
- Clean old backups automatically

---

## 🚀 Installation Steps

### Step 1: Run SQL Script

```bash
mysql -u your_user -p your_database < database_updates/add_backup_system.sql
```

Or import via phpMyAdmin.

### Step 2: Create Backup Directory

```bash
mkdir -p writable/backups
chmod 755 writable/backups
```

### Step 3: Test Manual Backup

1. Go to `/backups`
2. Click "Create Backup"
3. Wait for confirmation
4. See backup in list

---

## 📋 Features

### **Manual Backups**
- Click "Create Backup" button
- Add optional notes
- Download anytime
- Restore with one click

### **Automatic Backups**
- Schedule via cron job
- Choose frequency (daily/weekly)
- Auto-clean old backups
- Keep X most recent backups

### **Backup Management**
- View all backups in table
- See size, date, creator
- Download as SQL file
- Delete selected backups
- Clean old backups (keep N recent)

---

## ⚙️ Setup Automatic Backups

### Step 1: Enable Auto Backup

1. Go to `/backups`
2. Click "Auto Backup Settings"
3. Enable automatic backups
4. Choose frequency: Daily / Weekly
5. Set how many backups to keep
6. Save settings

### Step 2: Setup Cron Job

**For Daily Backups:**
```bash
crontab -e
```

Add this line:
```bash
0 2 * * * cd /home/erp/ShopSuite && php spark backup:auto >> /home/erp/ShopSuite/writable/logs/backup_cron.log 2>&1
```

This runs daily at 2:00 AM.

**For Weekly Backups:**
```bash
0 2 * * 0 cd /home/erp/ShopSuite && php spark backup:auto >> /home/erp/ShopSuite/writable/logs/backup_cron.log 2>&1
```

This runs weekly on Sunday at 2:00 AM.

**For Hourly Backups:**
```bash
0 * * * * cd /home/erp/ShopSuite && php spark backup:auto >> /home/erp/ShopSuite/writable/logs/backup_cron.log 2>&1
```

### Step 3: Test Cron Job

Run manually to test:
```bash
cd /home/erp/ShopSuite
php spark backup:auto
```

You should see:
```
Starting automatic backup...
Creating backup...
✓ Backup created successfully: backup_2025-01-24_12-00-00.sql
  Size: 5.23 MB
Cleaning old backups (keeping 10)...
No old backups to clean
Auto backup completed successfully
```

---

## 📊 Backup Management

### **View Backups**
- Go to `/backups`
- See all backups with:
  - Filename
  - Size (MB)
  - Type (Manual/Auto)
  - Creator
  - Date/Time
  - Notes

### **Create Backup**
1. Click "Create Backup"
2. Add notes (optional)
3. Wait for completion
4. Backup appears in list

### **Download Backup**
1. Click download icon (⬇)
2. SQL file downloads
3. Can be imported anywhere

### **Restore Backup**
1. Click restore icon (⟲)
2. Confirm warning
3. Database is restored
4. All data reverted to backup point

**⚠️ WARNING:** Restore replaces ALL current data!

### **Delete Backup**
1. Select checkbox(es)
2. Click "Delete Selected"
3. Or click trash icon for single backup
4. Confirms before deleting

### **Clean Old Backups**
1. Click "Clean Old"
2. Enter how many to keep (e.g., 10)
3. Deletes oldest backups
4. Keeps X most recent

---

## 🎯 Use Cases

### **Before Major Updates**
```
1. Create manual backup
2. Add note: "Before v3.2 update"
3. Perform update
4. If issues, restore backup
```

### **Daily Automatic Backups**
```
1. Enable auto backup (daily)
2. Keep 30 backups
3. System backs up every night
4. Old backups auto-deleted
```

### **Disaster Recovery**
```
1. Go to /backups
2. Find most recent backup
3. Click restore
4. System recovered
```

### **Data Migration**
```
1. Create backup
2. Download SQL file
3. Import to new server
4. Data migrated
```

---

## 📈 Statistics

The backup page shows:

**Total Backups:** Count of all backups  
**Total Size:** Combined size of all backups  
**Latest Backup:** Date of most recent backup  

---

## 🔧 Configuration

### **Auto Backup Settings**

| Setting | Description | Default |
|---------|-------------|---------|
| Auto Backup Enabled | Turn on/off automatic backups | Off |
| Backup Frequency | How often to backup | Daily |
| Keep Backups | How many to keep | 10 |

### **Storage Location**

Backups are stored in:
```
/home/erp/ShopSuite/writable/backups/
```

Filename format:
```
backup_YYYY-MM-DD_HH-MM-SS.sql
```

Example:
```
backup_2025-01-24_14-30-00.sql
```

---

## 🛡️ Security

### **Permissions**
- Only administrators can access backups
- File permissions: 0755
- Stored outside web root

### **Access Control**
- Requires 'backups' permission
- Default: Only employee ID 1 (admin)
- Can be assigned via Roles module

---

## 💡 Best Practices

### **Backup Frequency**
- **Production:** Daily backups
- **Development:** Weekly backups
- **Before updates:** Manual backup

### **Retention Policy**
- Keep 30 daily backups (1 month)
- Or 12 weekly backups (3 months)
- More for critical systems

### **Testing**
- Test restore monthly
- Verify backup integrity
- Check backup size

### **Storage**
- Monitor disk space
- Clean old backups regularly
- Download important backups offline

---

## 🐛 Troubleshooting

### Issue: Backup fails with permission error

**Solution:**
```bash
chmod 755 writable/backups
chown www-data:www-data writable/backups
```

### Issue: mysqldump command not found

**Solution:**
```bash
sudo apt-get install mysql-client
```

Or specify full path in Backup model.

### Issue: Cron job not running

**Check:**
1. Cron service running: `systemctl status cron`
2. Check cron log: `grep CRON /var/log/syslog`
3. Test command manually
4. Check file permissions

**Solution:**
```bash
sudo systemctl start cron
sudo systemctl enable cron
```

### Issue: Backup too large

**Solutions:**
- Clean old data
- Compress backups (gzip)
- Use incremental backups
- Increase disk space

---

## 📝 Command Line Usage

### Create Manual Backup
```bash
php spark backup:auto
```

### View Backup Log
```bash
tail -f writable/logs/backup_cron.log
```

### List Backups
```bash
ls -lh writable/backups/
```

### Delete Old Backups (Keep 5)
```bash
cd writable/backups/
ls -t | tail -n +6 | xargs rm
```

---

## 🔄 Restore Process

### Via Web Interface
1. Go to `/backups`
2. Find backup to restore
3. Click restore button
4. Confirm warning
5. Wait for completion

### Via Command Line
```bash
mysql -u username -p database_name < writable/backups/backup_file.sql
```

### Via phpMyAdmin
1. Go to phpMyAdmin
2. Select database
3. Click "Import"
4. Choose backup file
5. Click "Go"

---

## 📊 Monitoring

### Check Last Backup
```sql
SELECT * FROM backups ORDER BY created_at DESC LIMIT 1;
```

### Check Disk Usage
```bash
du -sh writable/backups/
```

### Count Backups
```sql
SELECT COUNT(*) FROM backups;
```

### Total Backup Size
```sql
SELECT SUM(file_size) / 1024 / 1024 AS total_mb FROM backups;
```

---

## ✅ Checklist

**Initial Setup:**
- [ ] Run SQL script
- [ ] Create backup directory
- [ ] Set permissions
- [ ] Test manual backup
- [ ] Test restore
- [ ] Test download

**Automatic Backup Setup:**
- [ ] Enable auto backup
- [ ] Configure frequency
- [ ] Set retention count
- [ ] Add cron job
- [ ] Test cron manually
- [ ] Wait for scheduled run
- [ ] Verify backup created

**Ongoing:**
- [ ] Monitor disk space
- [ ] Test restore monthly
- [ ] Review backup logs
- [ ] Clean old backups
- [ ] Download critical backups

---

## 🎉 You're All Set!

Your database backup system is ready! Access it at:

**`http://localhost/backups`**

Features:
- ✅ Manual backups
- ✅ Automatic backups
- ✅ Download backups
- ✅ Restore backups
- ✅ Clean old backups
- ✅ Backup history
- ✅ Size tracking

Keep your data safe! 🔒
