-- ================================================
-- ROLE-BASED PERMISSION SYSTEM
-- ================================================

-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `role_description` text DEFAULT NULL,
  `is_system_role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = system role (cannot be deleted), 0 = custom role',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create role_permissions table (links roles to permissions)
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` varchar(255) NOT NULL,
  `menu_group` varchar(32) NOT NULL DEFAULT 'home',
  PRIMARY KEY (`role_id`, `permission_id`),
  CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add role_id column to employees table
ALTER TABLE `employees` 
ADD COLUMN `role_id` int(11) unsigned DEFAULT NULL AFTER `person_id`,
ADD CONSTRAINT `fk_employees_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Insert default system roles
INSERT INTO `roles` (`role_name`, `role_description`, `is_system_role`, `created_at`) VALUES
('Administrator', 'Full system access with all permissions', 1, NOW()),
('Manager', 'Can manage inventory, sales, customers, and reports', 1, NOW()),
('Cashier', 'Can process sales and manage customers', 1, NOW()),
('Stock Manager', 'Can manage inventory and receivings', 1, NOW());

-- Add Roles module to modules table
INSERT INTO `modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_roles', 'module_roles_desc', 115, 'roles');

-- Add Roles permission
INSERT INTO `permissions` (`permission_id`, `module_id`) VALUES
('roles', 'roles');

-- Grant administrator role to employee ID 1
UPDATE `employees` SET `role_id` = 1 WHERE `person_id` = 1;

-- Give permission to employee ID 1 to access roles module
INSERT INTO `grants` (`permission_id`, `person_id`, `menu_group`) VALUES
('roles', 1, 'office');

-- ================================================
-- ASSIGN PERMISSIONS TO ROLES
-- ================================================

-- Administrator gets ALL permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `menu_group`)
SELECT 1, `permission_id`, 'both' FROM `permissions`;

-- Manager permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `menu_group`) VALUES
(2, 'sales', 'home'),
(2, 'items', 'both'),
(2, 'item_kits', 'both'),
(2, 'customers', 'both'),
(2, 'suppliers', 'office'),
(2, 'receivings', 'office'),
(2, 'reports', 'both'),
(2, 'giftcards', 'both'),
(2, 'employees', 'office'),
(2, 'office', 'both'),
(2, 'home', 'both');

-- Cashier permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `menu_group`) VALUES
(3, 'sales', 'home'),
(3, 'customers', 'home'),
(3, 'giftcards', 'home'),
(3, 'home', 'home');

-- Stock Manager permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `menu_group`) VALUES
(4, 'items', 'office'),
(4, 'item_kits', 'office'),
(4, 'receivings', 'office'),
(4, 'suppliers', 'office'),
(4, 'office', 'office');
