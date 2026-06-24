-- ================================================
-- GRANT ALL CRUD PERMISSIONS TO ADMIN
-- ================================================
-- Run this whenever new permissions are added
-- Ensures admin (person_id = 1) has full access
-- ================================================

-- Grant ALL CRUD permissions to admin
INSERT IGNORE INTO shopsuite_grants (permission_id, person_id, menu_group) 
SELECT permission_id, 1, 'both' 
FROM shopsuite_permissions 
WHERE permission_id LIKE '%_view' 
   OR permission_id LIKE '%_add' 
   OR permission_id LIKE '%_update' 
   OR permission_id LIKE '%_delete'
   OR permission_id LIKE '%_export'
   OR permission_id LIKE '%_manage_%'
   OR permission_id LIKE '%_create'
   OR permission_id LIKE '%_download'
   OR permission_id LIKE '%_restore'
   OR permission_id LIKE '%_send'
   OR permission_id LIKE '%_refund'
   OR permission_id LIKE '%_backup'
   OR permission_id LIKE '%_inventory'
   OR permission_id LIKE '%_sales'
   OR permission_id LIKE '%_change_%';

-- Also grant base module permissions
INSERT IGNORE INTO shopsuite_grants (permission_id, person_id, menu_group)
SELECT module_id, 1, 'both'
FROM shopsuite_modules;

-- Clear sessions so changes take effect
DELETE FROM shopsuite_sessions;

-- Verify
SELECT 
    'Admin now has ' || COUNT(*) || ' total permissions' as status
FROM shopsuite_grants 
WHERE person_id = 1;

-- Show employees permissions
SELECT 
    permission_id,
    menu_group
FROM shopsuite_grants 
WHERE person_id = 1 
AND permission_id LIKE 'employees%'
ORDER BY permission_id;
