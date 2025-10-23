ALTER TABLE `shopsuite_suppliers`
   ADD COLUMN `agency_name` VARCHAR(255) NOT NULL;

INSERT INTO `shopsuite_app_config` (`key`, `value`) VALUES
   ('dateformat', 'm/d/Y'),
   ('timeformat', 'H:i:s'),
   ('barcode_generate_if_empty', '0');

ALTER TABLE `shopsuite_sales_suspended`
    DROP KEY `invoice_number`;

ALTER TABLE `shopsuite_items`
  CHANGE COLUMN `item_pic` `pic_id` int(10) DEFAULT NULL;

-- Clear out emptied comments (0 inserted in comment if empty #192)
ALTER TABLE shopsuite_sales
MODIFY COLUMN comment text DEFAULT NULL;

ALTER TABLE shopsuite_receivings
MODIFY COLUMN comment text DEFAULT NULL;

ALTER TABLE shopsuite_sales_suspended
MODIFY COLUMN comment text DEFAULT NULL;

UPDATE `shopsuite_sales` SET comment = NULL WHERE comment = '0';
UPDATE `shopsuite_receivings` SET comment = NULL WHERE comment = '0';
UPDATE `shopsuite_sales_suspended` SET comment = NULL WHERE comment = '0';
