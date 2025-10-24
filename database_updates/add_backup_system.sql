-- ================================================
-- DATABASE BACKUP SYSTEM
-- ================================================

-- Create backups table
CREATE TABLE IF NOT EXISTS `backups` (
  `backup_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `backup_type` enum('manual','auto') NOT NULL DEFAULT 'manual',
  `created_by` int(10) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`backup_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_backups_employee` FOREIGN KEY (`created_by`) REFERENCES `employees` (`person_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add Backups module to modules table
INSERT INTO `modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_backups', 'module_backups_desc', 116, 'backups');

-- Add Backups permission
INSERT INTO `permissions` (`permission_id`, `module_id`) VALUES
('backups', 'backups');

-- Give permission to administrator (employee ID 1)
INSERT INTO `grants` (`permission_id`, `person_id`, `menu_group`) VALUES
('backups', 1, 'office');

-- Create backups directory (this should be done via file system, shown here for reference)
-- Directory: writable/backups/
-- Permissions: 0755

-- Add auto backup configuration settings
INSERT INTO `app_config` (`key`, `value`) VALUES
('auto_backup_enabled', '0'),
('backup_frequency', 'daily'),
('keep_backups', '10'),
('last_auto_backup', NULL);
