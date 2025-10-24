-- ================================================
-- FIX USER PERMISSIONS - Grant All Modules
-- ================================================

-- Get your person_id (should be 1 for admin)
-- If you're logged in as a different user, replace 1 with your person_id

-- Add missing module permissions to grants table
INSERT IGNORE INTO `grants` (`permission_id`, `person_id`, `menu_group`) VALUES
-- Main Menu
('home', 1, 'both'),

-- System Settings
('config', 1, 'office'),
('roles', 1, 'office'),
('employees', 1, 'office'),
('backups', 1, 'office'),

-- Business Settings
('taxes', 1, 'office'),
('attributes', 1, 'office'),

-- Financial Settings
('expenses_categories', 1, 'office'),

-- Tools
('migrate', 1, 'office');

-- Verify - Should show all modules
SELECT COUNT(*) as total_modules FROM grants WHERE person_id = 1;

-- List all your permissions
SELECT permission_id, menu_group FROM grants WHERE person_id = 1 ORDER BY permission_id;
