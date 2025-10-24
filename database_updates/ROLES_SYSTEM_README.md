# 🛡️ ROLE-BASED PERMISSION SYSTEM

## Overview

A complete role and permission management system has been created for your ShopSuite application. This allows you to:

- Create custom user roles
- Assign module permissions to roles
- Control who can access which modules
- Pre-configured roles for common positions
- Easy role assignment to employees

---

## 🚀 Installation Steps

### Step 1: Run the SQL Script

Execute the SQL script to create the database tables and default roles:

```bash
mysql -u your_user -p your_database < database_updates/add_roles_system.sql
```

Or import it via phpMyAdmin:
1. Open phpMyAdmin
2. Select your database
3. Go to "Import" tab
4. Choose file: `database_updates/add_roles_system.sql`
5. Click "Go"

### Step 2: Clear Cache

```bash
cd /home/erp/ShopSuite
php spark cache:clear
```

### Step 3: Access the Roles Module

Navigate to: **http://localhost/roles**

---

## 📋 Pre-Configured Roles

### 1. Administrator
- **Access:** ALL modules
- **Menu:** Both (Home & Office)
- **Use for:** System administrators, owners

### 2. Manager
- **Access:** Sales, Items, Customers, Suppliers, Receivings, Reports, Employees, Giftcards
- **Menu:** Both
- **Use for:** Store managers, supervisors

### 3. Cashier
- **Access:** Sales, Customers, Giftcards
- **Menu:** Home only
- **Use for:** Front desk staff, cashiers

### 4. Stock Manager
- **Access:** Items, Item Kits, Receivings, Suppliers
- **Menu:** Office only
- **Use for:** Warehouse staff, inventory managers

---

## 🎯 How to Use

### Creating a New Role

1. Go to **http://localhost/roles**
2. Click **"Create Role"** button
3. Enter role name and description
4. Select permissions:
   - Check boxes for modules you want to allow
   - Choose menu group for each permission:
     - **Home** = Appears in home menu only
     - **Office** = Appears in office menu only
     - **Both** = Appears in both menus
5. Click **"Save Role"**

### Editing a Role

1. Go to **http://localhost/roles**
2. Click on a role card or the **Edit** button
3. Modify permissions
4. Click **"Save Role"**

### Duplicating a Role

1. Go to **http://localhost/roles**
2. Click the **⋮** menu on a role card
3. Select **"Duplicate"**
4. Enter a new name
5. Modify permissions as needed

### Deleting a Role

1. Go to **http://localhost/roles**
2. Click the **⋮** menu on a role card
3. Select **"Delete"**
4. Confirm deletion

**Note:** System roles cannot be deleted, and you cannot delete roles that have users assigned to them.

###Assigning a Role to an Employee

1. Go to **Employees** module
2. Edit an employee
3. Select their **Role** from the dropdown
4. Save

---

## 🏗️ Database Structure

### Tables Created:

#### `roles`
```sql
- role_id (primary key)
- role_name
- role_description
- is_system_role (0 or 1)
- created_at
- updated_at
```

#### `role_permissions`
```sql
- role_id (foreign key to roles)
- permission_id (foreign key to permissions)
- menu_group (home/office/both)
```

#### `employees` (modified)
```sql
- role_id (foreign key to roles) [NEW COLUMN]
```

---

## 📖 Module Permissions

Each module in the system has a permission ID. Here are the main ones:

| Module | Permission ID | Description |
|--------|--------------|-------------|
| Sales | `sales` | Process sales and returns |
| Items | `items` | Manage inventory items |
| Customers | `customers` | Manage customer database |
| Suppliers | `suppliers` | Manage supplier database |
| Reports | `reports` | View and generate reports |
| Employees | `employees` | Manage staff |
| Receivings | `receivings` | Process purchase orders |
| Giftcards | `giftcards` | Manage gift cards |
| Config | `config` | System configuration |
| Roles | `roles` | Role & permission management |

---

## 🔒 Security Features

### System Role Protection
- System roles (Administrator, Manager, Cashier, Stock Manager) cannot be deleted
- System role names cannot be changed
- Only permissions can be modified for system roles

### Assignment Prevention
- Cannot delete a role if employees are assigned to it
- Must first reassign employees to different roles

### Administrator Safeguard
- Person ID 1 (default admin) is automatically assigned Administrator role
- Has full access to all modules including the roles module

---

## 💡 Best Practices

### 1. Role Design
- Create roles based on job functions, not individuals
- Use descriptive role names (e.g., "Part-Time Cashier", "Night Shift Manager")
- Document what each role can do in the description field

### 2. Permission Assignment
- Follow the principle of least privilege
- Only give permissions needed for the job
- Review permissions regularly

### 3. Menu Groups
- **Home** for POS-facing modules (sales, customers)
- **Office** for back-office modules (inventory, reports)
- **Both** for modules used in both contexts

### 4. Testing
- Create a test user with the new role
- Verify they can access intended modules
- Verify they cannot access restricted modules

---

## 🔧 Customization

### Creating Role Templates

Duplicate existing roles to create templates:

1. Start with a system role that's close to what you need
2. Duplicate it
3. Modify permissions
4. Save as a custom role

### Bulk Permission Assignment

Use "Select All" / "Deselect All" buttons when creating roles with many permissions.

---

## 📊 Role Statistics

The roles management page shows:
- **Permission Count:** Number of modules the role can access
- **User Count:** Number of employees assigned to the role

This helps you understand role usage and identify unused roles.

---

## 🐛 Troubleshooting

### Issue: Cannot access roles module
**Solution:** Make sure person_id 1 (admin) has the 'roles' permission in the grants table.

```sql
INSERT INTO grants (permission_id, person_id, menu_group) VALUES ('roles', 1, 'office');
```

### Issue: Employees table doesn't have role_id column
**Solution:** Run the SQL script again, or manually add the column:

```sql
ALTER TABLE employees ADD COLUMN role_id int(11) unsigned DEFAULT NULL AFTER person_id;
ALTER TABLE employees ADD CONSTRAINT fk_employees_role FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE SET NULL;
```

### Issue: Cannot delete a role
**Check:**
1. Is it a system role? (Cannot delete)
2. Are there employees assigned to it? (Reassign first)

---

## 🎨 UI Features

### Card-Based Layout
- Visual cards showing each role
- Quick stats at a glance
- Color-coded system roles (blue border)

### Permission Form
- Grouped by module
- Checkboxes for easy selection
- Menu group dropdowns
- Select/deselect all options

### Dropdown Actions
- Edit permissions
- Duplicate role
- Delete role (if allowed)

---

## 🔄 Migration from Old System

If you were using the old per-user grants system:

1. Roles are now the primary way to assign permissions
2. Old grants table still works (backward compatible)
3. Assign roles to employees gradually
4. Eventually migrate all users to roles

---

## 📝 Notes

- **System roles cannot be deleted** - This is by design to prevent accidents
- **Role names are unique** - You cannot create two roles with the same name
- **Permission changes are immediate** - When you update a role, all users with that role get the changes
- **Admin always has access** - Person ID 1 always has full access regardless of role

---

## 🎉 You're All Set!

Your role-based permission system is now ready to use. Start by:

1. Reviewing the pre-configured roles
2. Creating any custom roles you need
3. Assigning roles to your employees
4. Testing access with different user accounts

For support, refer to the main ShopSuite documentation or contact your system administrator.
