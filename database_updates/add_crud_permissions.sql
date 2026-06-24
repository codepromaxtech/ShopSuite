-- ================================================
-- ADD CRUD PERMISSIONS SYSTEM
-- ================================================
-- Create proper action-based permissions for all modules
-- View, Add, Update, Delete for each module
-- ================================================

-- CUSTOMERS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('customers_view', 'customers'),
('customers_add', 'customers'),
('customers_update', 'customers'),
('customers_delete', 'customers'),
('customers_export', 'customers');

-- ITEMS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('items_view', 'items'),
('items_add', 'items'),
('items_update', 'items'),
('items_delete', 'items'),
('items_export', 'items'),
('items_manage_stock', 'items');

-- SALES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('sales_view', 'sales'),
('sales_add', 'sales'),
('sales_update', 'sales'),
-- sales_delete already exists
('sales_export', 'sales'),
('sales_refund', 'sales');
-- sales_change_price already exists

-- SUPPLIERS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('suppliers_view', 'suppliers'),
('suppliers_add', 'suppliers'),
('suppliers_update', 'suppliers'),
('suppliers_delete', 'suppliers'),
('suppliers_export', 'suppliers');

-- EMPLOYEES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('employees_view', 'employees'),
('employees_add', 'employees'),
('employees_update', 'employees'),
('employees_delete', 'employees'),
('employees_manage_permissions', 'employees');

-- RECEIVINGS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('receivings_view', 'receivings'),
('receivings_add', 'receivings'),
('receivings_update', 'receivings'),
('receivings_delete', 'receivings');

-- REPORTS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('reports_view', 'reports'),
('reports_export', 'reports'),
('reports_sales', 'reports'),
('reports_inventory', 'reports'),
('reports_customers', 'reports'),
('reports_employees', 'reports');

-- GIFTCARDS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('giftcards_view', 'giftcards'),
('giftcards_add', 'giftcards'),
('giftcards_update', 'giftcards'),
('giftcards_delete', 'giftcards');

-- EXPENSES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('expenses_view', 'expenses'),
('expenses_add', 'expenses'),
('expenses_update', 'expenses'),
('expenses_delete', 'expenses');

-- CONFIG MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('config_view', 'config'),
('config_update', 'config'),
('config_backup', 'config');

-- BACKUPS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('backups_view', 'backups'),
('backups_create', 'backups'),
('backups_download', 'backups'),
('backups_restore', 'backups'),
('backups_delete', 'backups');

-- ROLES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('roles_view', 'roles'),
('roles_add', 'roles'),
('roles_update', 'roles'),
('roles_delete', 'roles');

-- TAXES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('taxes_view', 'taxes'),
('taxes_add', 'taxes'),
('taxes_update', 'taxes'),
('taxes_delete', 'taxes');

-- ATTRIBUTES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('attributes_view', 'attributes'),
('attributes_add', 'attributes'),
('attributes_update', 'attributes'),
('attributes_delete', 'attributes');

-- EXPENSES CATEGORIES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('expenses_categories_view', 'expenses_categories'),
('expenses_categories_add', 'expenses_categories'),
('expenses_categories_update', 'expenses_categories'),
('expenses_categories_delete', 'expenses_categories');

-- CASHUPS MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('cashups_view', 'cashups'),
('cashups_add', 'cashups'),
('cashups_update', 'cashups'),
('cashups_delete', 'cashups');

-- MESSAGES MODULE
INSERT IGNORE INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('messages_view', 'messages'),
('messages_send', 'messages'),
('messages_delete', 'messages');

-- Verify
SELECT 
    module_id,
    COUNT(*) as permission_count,
    GROUP_CONCAT(SUBSTRING_INDEX(permission_id, '_', -1) SEPARATOR ', ') as actions
FROM shopsuite_permissions 
WHERE permission_id LIKE '%_view' 
   OR permission_id LIKE '%_add'
   OR permission_id LIKE '%_update'
   OR permission_id LIKE '%_delete'
GROUP BY module_id
ORDER BY module_id;
