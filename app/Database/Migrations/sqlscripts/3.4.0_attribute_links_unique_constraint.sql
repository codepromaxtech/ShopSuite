# Prevents duplicate attribute links with the same definition_id and item_id.
# This accounts for dropdown rows (null item_id) and rows associated with sales or receivings.
ALTER TABLE `shopsuite_attribute_links`
    ADD COLUMN `generated_unique_column` VARCHAR(255) GENERATED ALWAYS AS (
        CASE
            WHEN `sale_id` IS NULL AND `receiving_id` IS NULL AND `item_id` IS NOT NULL THEN CONCAT(`definition_id`, '-', `item_id`)
            ELSE NULL
        END
        ) STORED,
    ADD UNIQUE INDEX `attribute_links_uq3` (`generated_unique_column`);

ALTER TABLE `shopsuite_attribute_links`    ADD CONSTRAINT `shopsuite_attribute_links_ibfk_1` FOREIGN KEY (`definition_id`) REFERENCES `shopsuite_attribute_definitions` (`definition_id`) ON DELETE RESTRICT;
ALTER TABLE `shopsuite_attribute_links`    ADD CONSTRAINT `shopsuite_attribute_links_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `shopsuite_attribute_values` (`attribute_id`) ON DELETE RESTRICT;
ALTER TABLE `shopsuite_attribute_links`    ADD CONSTRAINT `shopsuite_attribute_links_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`);
ALTER TABLE `shopsuite_attribute_links`    ADD CONSTRAINT `shopsuite_attribute_links_ibfk_4` FOREIGN KEY (`receiving_id`) REFERENCES `shopsuite_receivings` (`receiving_id`);
ALTER TABLE `shopsuite_attribute_links`    ADD CONSTRAINT `shopsuite_attribute_links_ibfk_5` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`);
