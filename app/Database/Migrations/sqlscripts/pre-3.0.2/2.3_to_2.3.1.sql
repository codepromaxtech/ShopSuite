-- alter permissions table
DROP TABLE `shopsuite_permissions`;

CREATE TABLE `shopsuite_permissions` (
  `permission_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `location_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `shopsuite_permissions`
  ADD CONSTRAINT `shopsuite_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `shopsuite_modules` (`module_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopsuite_permissions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `shopsuite_stock_locations` (`location_id`) ON DELETE CASCADE;

INSERT INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('reports_customers', 'reports'),
('reports_receivings', 'reports'),
('reports_items', 'reports'),
('reports_employees', 'reports'),
('reports_suppliers', 'reports'),
('reports_sales', 'reports'),
('reports_discounts', 'reports'),
('reports_taxes', 'reports'),
('reports_inventory', 'reports'),
('reports_categories', 'reports'),
('reports_payments', 'reports'),
('customers', 'customers'),
('employees', 'employees'),
('giftcards', 'giftcards'),
('items', 'items'),
('item_kits', 'item_kits'),
('receivings', 'receivings'),
('reports', 'reports'),
('sales', 'sales'),
('config', 'config'),
('suppliers', 'suppliers'),
('sales_stock', 'sales'),
('receivings_stock', 'receivings');

-- add permissions for existing stock locations
INSERT INTO `shopsuite_permissions` (permission_id, module_id, location_id)
(SELECT CONCAT('items_', location_name), 'items', location_id FROM shopsuite_stock_locations);

CREATE TABLE `shopsuite_grants` (
  `permission_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`permission_id`,`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `shopsuite_grants`
  ADD CONSTRAINT `shopsuite_grants_ibfk_2` foreign key (`person_id`) references `shopsuite_employees` (`person_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopsuite_grants_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `shopsuite_permissions`(`permission_id`) ON DELETE CASCADE;

-- add grants for all employees
INSERT INTO `shopsuite_grants` (`permission_id`, `person_id`) VALUES
('reports_customers', 1),
('reports_receivings', 1),
('reports_items', 1),
('reports_inventory', 1),
('reports_employees', 1),
('reports_suppliers', 1),
('reports_sales', 1),
('reports_categories', 1),
('reports_discounts', 1),
('reports_payments', 1),
('reports_taxes', 1),
('customers', 1),
('employees', 1),
('giftcards', 1),
('items', 1),
('item_kits', 1),
('receivings', 1),
('reports', 1),
('sales', 1),
('config', 1),
('items_stock', 1),
('sales_stock', 1),
('receivings_stock', 1),
('suppliers', 1);

-- add config options for tax inclusive sales
INSERT INTO `shopsuite_app_config` (`key`, `value`) VALUES
('tax_included', '0'),
('recv_invoice_format', '$CO'),
('sales_invoice_format', '$CO');

-- add invoice_number column to receivings table
ALTER TABLE `shopsuite_receivings`
   ADD COLUMN `invoice_number` varchar(32) DEFAULT NULL,
   ADD UNIQUE `invoice_number` (`invoice_number`);

-- add invoice_number column to sales table
ALTER TABLE `shopsuite_sales`
   ADD COLUMN `invoice_number` varchar(32) DEFAULT NULL,
   ADD UNIQUE `invoice_number` (`invoice_number`);

-- add invoice_number column to suspended sales table
ALTER TABLE `shopsuite_sales_suspended`
   ADD COLUMN `invoice_number` varchar(32) DEFAULT NULL,
   ADD UNIQUE `invoice_number` (`invoice_number`);

-- add invoice_number column to receivings table
ALTER TABLE `shopsuite_items`
   ADD COLUMN `receiving_quantity` int(11) DEFAULT '1',
   DROP COLUMN `quantity`;

-- add record_time column to shopsuite_giftcards table
ALTER TABLE shopsuite_giftcards ADD record_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- add foreign key to giftcards table
ALTER TABLE `shopsuite_giftcards`
  ADD CONSTRAINT `shopsuite_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);
