-- ================================================
-- FIX MENU GROUP PERMISSIONS
-- ================================================
-- Issue: Modules were showing in 'office' menu group only
-- Fix: Set critical modules to 'both' so they appear in all menus
-- ================================================

-- Update menu_group to 'both' for all system modules
UPDATE shopsuite_grants 
SET menu_group = 'both' 
WHERE person_id = 1 
AND permission_id IN (
    'home',
    'config',
    'roles', 
    'employees',
    'backups',
    'taxes',
    'attributes',
    'expenses_categories'
);

-- Clear all sessions to force permission reload
DELETE FROM shopsuite_sessions;

-- Verify the changes
SELECT 
    permission_id, 
    menu_group,
    CASE 
        WHEN menu_group = 'both' THEN '✅ Visible in all menus'
        WHEN menu_group = 'home' THEN 'Home menu only'
        WHEN menu_group = 'office' THEN 'Office menu only'
    END as visibility
FROM shopsuite_grants 
WHERE person_id = 1 
AND permission_id IN ('home', 'config', 'roles', 'employees', 'backups', 'taxes', 'attributes', 'expenses_categories')
ORDER BY permission_id;

-- Count total permissions
SELECT COUNT(*) as total_permissions 
FROM shopsuite_grants 
WHERE person_id = 1;
