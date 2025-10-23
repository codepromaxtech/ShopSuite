INSERT INTO `shopsuite_permissions` (`permission_id`, `module_id`) VALUES
('sales_change_price', 'sales');

INSERT INTO `shopsuite_grants` (`permission_id`, `person_id`, `menu_group`) VALUES
('sales_change_price', 1, '--');
