#shopsuite_attribute_values table
ALTER TABLE `shopsuite_attribute_values` ADD UNIQUE(`attribute_date`);
ALTER TABLE `shopsuite_attribute_values` ADD UNIQUE(`attribute_decimal`);

#opsos_attribute_definitions table
ALTER TABLE `shopsuite_attribute_definitions` MODIFY `definition_flags` tinyint(1) NOT NULL;
ALTER TABLE `shopsuite_attribute_definitions` ADD INDEX(`definition_name`);
ALTER TABLE `shopsuite_attribute_definitions` ADD INDEX(`definition_type`);

#shopsuite_cash_up table
ALTER TABLE `shopsuite_cash_up` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_customers table
ALTER TABLE `shopsuite_customers` DROP FOREIGN KEY `shopsuite_customers_ibfk_1`;
ALTER TABLE `shopsuite_customers_points` DROP FOREIGN KEY `shopsuite_customers_points_ibfk_1`;
ALTER TABLE `shopsuite_sales` DROP FOREIGN KEY `shopsuite_sales_ibfk_2`;

ALTER TABLE `shopsuite_customers` MODIFY `taxable` tinyint(1) DEFAULT 1 NOT NULL;
ALTER TABLE `shopsuite_customers` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_customers` MODIFY `discount_type` tinyint(1) DEFAULT 0 NOT NULL;

ALTER TABLE `shopsuite_customers` ADD CONSTRAINT `shopsuite_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people`(`person_id`);
ALTER TABLE `shopsuite_customers_points` ADD CONSTRAINT `shopsuite_customers_points_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_customers` (`person_id`);
ALTER TABLE `shopsuite_sales` ADD CONSTRAINT `shopsuite_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `shopsuite_customers` (`person_id`);

#shopsuite_customers_packages table
ALTER TABLE `shopsuite_customers_packages` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_dinner_tables table
ALTER TABLE `shopsuite_dinner_tables` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_dinner_tables` ADD INDEX(`status`);

#shopsuite_employees table
ALTER TABLE `shopsuite_sales_payments` DROP FOREIGN KEY `shopsuite_sales_payments_ibfk_2`;
ALTER TABLE `shopsuite_sales` DROP FOREIGN KEY `shopsuite_sales_ibfk_1`;
ALTER TABLE `shopsuite_receivings` DROP FOREIGN KEY `shopsuite_receivings_ibfk_1`;
ALTER TABLE `shopsuite_inventory` DROP FOREIGN KEY `shopsuite_inventory_ibfk_2`;
ALTER TABLE `shopsuite_grants` DROP FOREIGN KEY `shopsuite_grants_ibfk_2`;
ALTER TABLE `shopsuite_expenses` DROP FOREIGN KEY `shopsuite_expenses_ibfk_2`;
ALTER TABLE `shopsuite_employees` DROP FOREIGN KEY `shopsuite_employees_ibfk_1`;
ALTER TABLE `shopsuite_cash_up` DROP FOREIGN KEY `shopsuite_cash_up_ibfk_1`;
ALTER TABLE `shopsuite_cash_up` DROP FOREIGN KEY `shopsuite_cash_up_ibfk_2`;

ALTER TABLE `shopsuite_employees` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_employees` MODIFY `hash_version` tinyint(1) DEFAULT 2 NOT NULL;

ALTER TABLE `shopsuite_sales_payments` ADD CONSTRAINT `shopsuite_sales_payments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_sales` ADD CONSTRAINT `shopsuite_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_receivings` ADD CONSTRAINT `shopsuite_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_inventory` ADD CONSTRAINT `shopsuite_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_grants` ADD CONSTRAINT `shopsuite_grants_ibfk_2` foreign key (`person_id`) references `shopsuite_employees` (`person_id`) ON DELETE CASCADE;
ALTER TABLE `shopsuite_expenses` ADD CONSTRAINT `shopsuite_expenses_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_employees` ADD CONSTRAINT `shopsuite_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);
ALTER TABLE `shopsuite_cash_up` ADD CONSTRAINT `shopsuite_cash_up_ibfk_1` FOREIGN KEY (`open_employee_id`) REFERENCES `shopsuite_employees` (`person_id`);
ALTER TABLE `shopsuite_cash_up` ADD CONSTRAINT `shopsuite_cash_up_ibfk_2` FOREIGN KEY (`close_employee_id`) REFERENCES `shopsuite_employees` (`person_id`);

#shopsuite_expenses table
ALTER TABLE `shopsuite_expenses` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_expenses` ADD INDEX(`payment_type`);
ALTER TABLE `shopsuite_expenses` ADD INDEX(`amount`);

#shopsuite_expenses_categories table
ALTER TABLE `shopsuite_expense_categories` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_expense_categories` ADD INDEX(`category_description`);

#shopsuite_giftcards table
ALTER TABLE `shopsuite_giftcards` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_items table
ALTER TABLE `shopsuite_items` DROP FOREIGN KEY `shopsuite_items_ibfk_1`;
ALTER TABLE `shopsuite_items` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_items` MODIFY `stock_type` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_items` MODIFY `item_type` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_items` ADD INDEX(`deleted`, `item_type`);
ALTER TABLE `shopsuite_items` ADD INDEX (`item_id`,`deleted`);
ALTER TABLE `shopsuite_items` ADD UNIQUE INDEX `items_uq1` (`supplier_id`, `item_id`, `deleted`, `item_type`);

#shopsuite_item_kits table
ALTER TABLE `shopsuite_item_kits` MODIFY `kit_discount_type` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_item_kits` MODIFY `price_option` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_item_kits` MODIFY `print_option` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_item_kits` ADD INDEX(`name`,`description`);

#shopsuite_people table
ALTER TABLE `shopsuite_people` ADD INDEX(`first_name`, `last_name`, `email`, `phone_number`);

#shopsuite_receivings_items
ALTER TABLE `shopsuite_receivings_items` MODIFY `discount_type` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_sales
ALTER TABLE `shopsuite_sales` MODIFY `sale_status` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_sales` MODIFY `sale_type` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_sales_items
ALTER TABLE `shopsuite_sales_items` MODIFY `discount_type` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_sales_items` MODIFY `print_option` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_sales_items_taxes
ALTER TABLE `shopsuite_sales_items_taxes` MODIFY `tax_type` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_sales_items_taxes` MODIFY `rounding_code` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_sales_items_taxes` MODIFY `cascade_sequence` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_sales_taxes
ALTER TABLE `shopsuite_sales_taxes` MODIFY `print_sequence` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_sales_taxes` MODIFY `rounding_code` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_sessions table
ALTER TABLE `shopsuite_sessions` ADD INDEX(`id`);
ALTER TABLE `shopsuite_sessions` ADD INDEX(`ip_address`);

#shopsuite_stock_locations table
ALTER TABLE `shopsuite_stock_locations` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_suppliers table
ALTER TABLE `shopsuite_expenses` DROP FOREIGN KEY `shopsuite_expenses_ibfk_3`;
ALTER TABLE `shopsuite_receivings` DROP FOREIGN KEY `shopsuite_receivings_ibfk_2`;
ALTER TABLE `shopsuite_suppliers` DROP FOREIGN KEY `shopsuite_suppliers_ibfk_1`;

ALTER TABLE `shopsuite_suppliers` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_suppliers` MODIFY `category` tinyint(1) NOT NULL;
ALTER TABLE `shopsuite_suppliers` ADD INDEX(`category`);
ALTER TABLE `shopsuite_suppliers` ADD INDEX(`company_name`, `deleted`);

ALTER TABLE `shopsuite_expenses` ADD CONSTRAINT `shopsuite_expenses_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`);
ALTER TABLE `shopsuite_items` ADD CONSTRAINT `shopsuite_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`);
ALTER TABLE `shopsuite_receivings` ADD CONSTRAINT `shopsuite_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`);
ALTER TABLE `shopsuite_suppliers` ADD CONSTRAINT `shopsuite_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);

#shopsuite_tax_categories table
ALTER TABLE `shopsuite_tax_categories` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_tax_categories` MODIFY `tax_group_sequence` tinyint(1) NOT NULL;

#shopsuite_tax_jurisdictions table
ALTER TABLE `shopsuite_tax_jurisdictions` MODIFY `deleted` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_tax_jurisdictions` MODIFY `tax_group_sequence` tinyint(1) DEFAULT 0 NOT NULL;
ALTER TABLE `shopsuite_tax_jurisdictions` MODIFY `cascade_sequence` tinyint(1) DEFAULT 0 NOT NULL;

#shopsuite_tax_rates table
ALTER TABLE `shopsuite_tax_rates` MODIFY `tax_rounding_code` tinyint(1) DEFAULT 0 NOT NULL;
