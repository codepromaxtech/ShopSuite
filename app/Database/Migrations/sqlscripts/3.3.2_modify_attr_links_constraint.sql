ALTER TABLE `shopsuite_attribute_links`
DROP FOREIGN KEY `shopsuite_attribute_links_ibfk_4`;

ALTER TABLE `shopsuite_attribute_links`
ADD CONSTRAINT `shopsuite_attribute_links_ibfk_4`
FOREIGN KEY (`receiving_id`) REFERENCES `shopsuite_receivings`(`receiving_id`)
ON DELETE CASCADE
ON UPDATE RESTRICT;
