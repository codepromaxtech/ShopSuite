--
-- Constraints for dumped tables
--

--
-- Constraints for table `shopsuite_customers`
--
ALTER TABLE `shopsuite_customers`
    ADD CONSTRAINT `shopsuite_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);

--
-- Constraints for table `shopsuite_employees`
--
ALTER TABLE `shopsuite_employees`
    ADD CONSTRAINT `shopsuite_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);

--
-- Constraints for table `shopsuite_inventory`
--
ALTER TABLE `shopsuite_inventory`
    ADD CONSTRAINT `shopsuite_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `shopsuite_items` (`item_id`),
    ADD CONSTRAINT `shopsuite_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `shopsuite_employees` (`person_id`),
    ADD CONSTRAINT `shopsuite_inventory_ibfk_3` FOREIGN KEY (`trans_location`) REFERENCES `shopsuite_stock_locations` (`location_id`);

--
-- Constraints for table `shopsuite_items`
--
ALTER TABLE `shopsuite_items`
    ADD CONSTRAINT `shopsuite_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`);

--
-- Constraints for table `shopsuite_items_taxes`
--
ALTER TABLE `shopsuite_items_taxes`
    ADD CONSTRAINT `shopsuite_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopsuite_item_kit_items`
--
ALTER TABLE `shopsuite_item_kit_items`
    ADD CONSTRAINT `shopsuite_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `shopsuite_item_kits` (`item_kit_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `shopsuite_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`)  ON DELETE CASCADE;

--
-- Constraints for table `shopsuite_permissions`
--
ALTER TABLE `shopsuite_permissions`
    ADD CONSTRAINT `shopsuite_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `shopsuite_modules` (`module_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `shopsuite_permissions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `shopsuite_stock_locations` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopsuite_grants`
--
ALTER TABLE `shopsuite_grants`
    ADD CONSTRAINT `shopsuite_grants_ibfk_1` foreign key (`permission_id`) references `shopsuite_permissions` (`permission_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `shopsuite_grants_ibfk_2` foreign key (`person_id`) references `shopsuite_employees` (`person_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopsuite_receivings`
--
ALTER TABLE `shopsuite_receivings`
    ADD CONSTRAINT `shopsuite_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
    ADD CONSTRAINT `shopsuite_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`);

--
-- Constraints for table `shopsuite_receivings_items`
--
ALTER TABLE `shopsuite_receivings_items`
    ADD CONSTRAINT `shopsuite_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
    ADD CONSTRAINT `shopsuite_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `shopsuite_receivings` (`receiving_id`);

--
-- Constraints for table `shopsuite_sales`
--
ALTER TABLE `shopsuite_sales`
    ADD CONSTRAINT `shopsuite_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
    ADD CONSTRAINT `shopsuite_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `shopsuite_customers` (`person_id`);

--
-- Constraints for table `shopsuite_sales_items`
--
ALTER TABLE `shopsuite_sales_items`
    ADD CONSTRAINT `shopsuite_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
    ADD CONSTRAINT `shopsuite_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`),
    ADD CONSTRAINT `shopsuite_sales_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `shopsuite_stock_locations` (`location_id`);

--
-- Constraints for table `shopsuite_sales_items_taxes`
--
ALTER TABLE `shopsuite_sales_items_taxes`
    ADD CONSTRAINT `shopsuite_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`,`item_id`,`line`) REFERENCES `shopsuite_sales_items` (`sale_id`,`item_id`,`line`),
    ADD CONSTRAINT `shopsuite_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`);

--
-- Constraints for table `shopsuite_sales_payments`
--
ALTER TABLE `shopsuite_sales_payments`
    ADD CONSTRAINT `shopsuite_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`);

--
-- Constraints for table `shopsuite_sales_suspended`
--
ALTER TABLE `shopsuite_sales_suspended`
    ADD CONSTRAINT `shopsuite_sales_suspended_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
    ADD CONSTRAINT `shopsuite_sales_suspended_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `shopsuite_customers` (`person_id`);

--
-- Constraints for table `shopsuite_sales_suspended_items`
--
ALTER TABLE `shopsuite_sales_suspended_items`
    ADD CONSTRAINT `shopsuite_sales_suspended_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
    ADD CONSTRAINT `shopsuite_sales_suspended_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales_suspended` (`sale_id`),
    ADD CONSTRAINT `shopsuite_sales_suspended_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `shopsuite_stock_locations` (`location_id`);

--
-- Constraints for table `shopsuite_sales_suspended_items_taxes`
--
ALTER TABLE `shopsuite_sales_suspended_items_taxes`
    ADD CONSTRAINT `shopsuite_sales_suspended_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`,`item_id`,`line`) REFERENCES `shopsuite_sales_suspended_items` (`sale_id`,`item_id`,`line`),
    ADD CONSTRAINT `shopsuite_sales_suspended_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`);

--
-- Constraints for table `shopsuite_sales_suspended_payments`
--
ALTER TABLE `shopsuite_sales_suspended_payments`
    ADD CONSTRAINT `shopsuite_sales_suspended_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales_suspended` (`sale_id`);

--
-- Constraints for table `shopsuite_item_quantities`
--
ALTER TABLE `shopsuite_item_quantities`
    ADD CONSTRAINT `shopsuite_item_quantities_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
    ADD CONSTRAINT `shopsuite_item_quantities_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `shopsuite_stock_locations` (`location_id`);

--
-- Constraints for table `shopsuite_suppliers`
--
ALTER TABLE `shopsuite_suppliers`
    ADD CONSTRAINT `shopsuite_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);

--
-- Constraints for table `shopsuite_giftcards`
--
ALTER TABLE `shopsuite_giftcards`
    ADD CONSTRAINT `shopsuite_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`);
