/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: shopsuite
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `shopsuite_app_config`
--

DROP TABLE IF EXISTS `shopsuite_app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_app_config` (
  `key` varchar(50) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_app_config`
--

LOCK TABLES `shopsuite_app_config` WRITE;
/*!40000 ALTER TABLE `shopsuite_app_config` DISABLE KEYS */;
INSERT INTO `shopsuite_app_config` VALUES
('account_number',''),
('address','123 Nowhere street'),
('allow_duplicate_barcodes','0'),
('barcode_content','id'),
('barcode_first_row','category'),
('barcode_font','Arial'),
('barcode_font_size','10'),
('barcode_formats','[]'),
('barcode_generate_if_empty','0'),
('barcode_height','50'),
('barcode_num_in_row','2'),
('barcode_page_cellspacing','20'),
('barcode_page_width','100'),
('barcode_second_row','item_code'),
('barcode_third_row','unit_price'),
('barcode_type','C39'),
('barcode_width','250'),
('cash_decimals','2'),
('cash_rounding_code','0'),
('category_dropdown',''),
('company','ShopSuite'),
('company_logo',''),
('country_codes','us'),
('currency_code',''),
('currency_decimals','2'),
('currency_symbol','$'),
('customer_reward_enable','0'),
('dateformat','m/d/Y'),
('date_or_time_format',''),
('default_receivings_discount','0'),
('default_receivings_discount_type','0'),
('default_register_mode','sale'),
('default_sales_discount','0'),
('default_sales_discount_type','0'),
('default_tax_1_name',''),
('default_tax_1_rate',''),
('default_tax_2_name',''),
('default_tax_2_rate',''),
('default_tax_category','Standard'),
('default_tax_code',''),
('default_tax_jurisdiction',''),
('default_tax_rate','8'),
('derive_sale_quantity','0'),
('dinner_table_enable','0'),
('email','changeme@example.com'),
('email_receipt_check_behaviour','last'),
('enforce_privacy','0'),
('fax',''),
('financial_year','1'),
('gcaptcha_enable','0'),
('gcaptcha_secret_key',''),
('gcaptcha_site_key',''),
('giftcard_number','series'),
('image_allowed_types','gif,jpg,png'),
('image_max_height','480'),
('image_max_size','128'),
('image_max_width','640'),
('include_hsn','0'),
('invoice_default_comments','This is a default comment'),
('invoice_email_message','Dear {CU}, In attachment the receipt for sale {ISEQ}'),
('invoice_enable','1'),
('invoice_type','invoice'),
('language','english'),
('language_code','en'),
('last_used_invoice_number','0'),
('last_used_quote_number','0'),
('last_used_work_order_number','0'),
('lines_per_page','25'),
('line_sequence','0'),
('login_form',''),
('mailpath','/usr/sbin/sendmail'),
('msg_msg',''),
('msg_pwd',''),
('msg_src',''),
('msg_uid',''),
('multi_pack_enabled','0'),
('notify_horizontal_position','center'),
('notify_vertical_position','bottom'),
('number_locale','en_US'),
('payment_message',''),
('payment_options_order','cashdebitcredit'),
('phone','555-555-5555'),
('print_bottom_margin','0'),
('print_delay_autoreturn','0'),
('print_footer','0'),
('print_header','0'),
('print_left_margin','0'),
('print_receipt_check_behaviour','last'),
('print_right_margin','0'),
('print_silently','1'),
('print_top_margin','0'),
('protocol','mail'),
('quantity_decimals','0'),
('quote_default_comments','This is a default quote comment'),
('receipt_font_size','12'),
('receipt_show_company_name','1'),
('receipt_show_description','1'),
('receipt_show_serialnumber','1'),
('receipt_show_taxes','0'),
('receipt_show_tax_ind','0'),
('receipt_show_total_discount','1'),
('receipt_template','receipt_default'),
('receiving_calculate_average_price',''),
('recv_invoice_format','{CO}'),
('return_policy','Test'),
('sales_invoice_format','{CO}'),
('sales_quote_format','Q%y{QSEQ:6}'),
('smtp_crypto','ssl'),
('smtp_host',''),
('smtp_pass',''),
('smtp_port','465'),
('smtp_timeout','5'),
('smtp_user',''),
('statistics','1'),
('suggestions_first_column','name'),
('suggestions_second_column',''),
('suggestions_third_column',''),
('tax_decimals','2'),
('tax_id',''),
('tax_included','0'),
('theme','flatly'),
('thousands_separator','1'),
('timeformat','H:i:s'),
('timezone','America/New_York'),
('use_destination_based_tax','0'),
('website',''),
('work_order_enable','0'),
('work_order_format','W%y{WSEQ:6}');
/*!40000 ALTER TABLE `shopsuite_app_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_attribute_definitions`
--

DROP TABLE IF EXISTS `shopsuite_attribute_definitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_attribute_definitions` (
  `definition_id` int(10) NOT NULL AUTO_INCREMENT,
  `definition_name` varchar(255) NOT NULL,
  `definition_type` varchar(45) NOT NULL,
  `definition_unit` varchar(16) DEFAULT NULL,
  `definition_flags` tinyint(1) NOT NULL,
  `definition_fk` int(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`definition_id`),
  KEY `definition_fk` (`definition_fk`),
  KEY `definition_name` (`definition_name`),
  KEY `definition_type` (`definition_type`),
  CONSTRAINT `fk_shopsuite_attribute_definitions_ibfk_1` FOREIGN KEY (`definition_fk`) REFERENCES `shopsuite_attribute_definitions` (`definition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_attribute_definitions`
--

LOCK TABLES `shopsuite_attribute_definitions` WRITE;
/*!40000 ALTER TABLE `shopsuite_attribute_definitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_attribute_definitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_attribute_links`
--

DROP TABLE IF EXISTS `shopsuite_attribute_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_attribute_links` (
  `attribute_id` int(11) DEFAULT NULL,
  `definition_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `receiving_id` int(11) DEFAULT NULL,
  `generated_unique_column` varchar(255) GENERATED ALWAYS AS (case when `sale_id` is null and `receiving_id` is null and `item_id` is not null then concat(`definition_id`,'-',`item_id`) else NULL end) STORED,
  UNIQUE KEY `attribute_links_uq1` (`attribute_id`,`definition_id`,`item_id`,`sale_id`,`receiving_id`),
  UNIQUE KEY `attribute_links_uq2` (`item_id`,`receiving_id`,`sale_id`,`definition_id`,`attribute_id`),
  UNIQUE KEY `attribute_links_uq3` (`generated_unique_column`),
  KEY `attribute_id` (`attribute_id`),
  KEY `definition_id` (`definition_id`),
  KEY `item_id` (`item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `receiving_id` (`receiving_id`),
  CONSTRAINT `shopsuite_attribute_links_ibfk_1` FOREIGN KEY (`definition_id`) REFERENCES `shopsuite_attribute_definitions` (`definition_id`),
  CONSTRAINT `shopsuite_attribute_links_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `shopsuite_attribute_values` (`attribute_id`),
  CONSTRAINT `shopsuite_attribute_links_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
  CONSTRAINT `shopsuite_attribute_links_ibfk_4` FOREIGN KEY (`receiving_id`) REFERENCES `shopsuite_receivings` (`receiving_id`),
  CONSTRAINT `shopsuite_attribute_links_ibfk_5` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_attribute_links`
--

LOCK TABLES `shopsuite_attribute_links` WRITE;
/*!40000 ALTER TABLE `shopsuite_attribute_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_attribute_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_attribute_values`
--

DROP TABLE IF EXISTS `shopsuite_attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_attribute_values` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(255) DEFAULT NULL,
  `attribute_date` date DEFAULT NULL,
  `attribute_decimal` decimal(7,3) DEFAULT NULL,
  PRIMARY KEY (`attribute_id`),
  UNIQUE KEY `attribute_value` (`attribute_value`),
  UNIQUE KEY `attribute_date` (`attribute_date`),
  UNIQUE KEY `attribute_decimal` (`attribute_decimal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_attribute_values`
--

LOCK TABLES `shopsuite_attribute_values` WRITE;
/*!40000 ALTER TABLE `shopsuite_attribute_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_backups`
--

DROP TABLE IF EXISTS `shopsuite_backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_backups` (
  `backup_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `backup_type` enum('manual','auto') NOT NULL DEFAULT 'manual',
  `created_by` int(10) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`backup_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_backups`
--

LOCK TABLES `shopsuite_backups` WRITE;
/*!40000 ALTER TABLE `shopsuite_backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_cash_up`
--

DROP TABLE IF EXISTS `shopsuite_cash_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_cash_up` (
  `cashup_id` int(10) NOT NULL AUTO_INCREMENT,
  `open_date` timestamp NULL DEFAULT current_timestamp(),
  `close_date` timestamp NULL DEFAULT NULL,
  `open_amount_cash` decimal(15,2) NOT NULL,
  `transfer_amount_cash` decimal(15,2) NOT NULL,
  `note` tinyint(4) NOT NULL DEFAULT 0,
  `closed_amount_cash` decimal(15,2) NOT NULL,
  `closed_amount_card` decimal(15,2) NOT NULL,
  `closed_amount_check` decimal(15,2) NOT NULL,
  `closed_amount_total` decimal(15,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `open_employee_id` int(10) NOT NULL,
  `close_employee_id` int(10) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `closed_amount_due` decimal(15,2) NOT NULL,
  PRIMARY KEY (`cashup_id`),
  KEY `open_employee_id` (`open_employee_id`),
  KEY `close_employee_id` (`close_employee_id`),
  CONSTRAINT `shopsuite_cash_up_ibfk_1` FOREIGN KEY (`open_employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
  CONSTRAINT `shopsuite_cash_up_ibfk_2` FOREIGN KEY (`close_employee_id`) REFERENCES `shopsuite_employees` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_cash_up`
--

LOCK TABLES `shopsuite_cash_up` WRITE;
/*!40000 ALTER TABLE `shopsuite_cash_up` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_cash_up` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_customers`
--

DROP TABLE IF EXISTS `shopsuite_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_customers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` tinyint(1) NOT NULL DEFAULT 1,
  `tax_id` varchar(32) NOT NULL DEFAULT '',
  `sales_tax_code_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_type` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` int(10) NOT NULL,
  `consent` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`person_id`),
  KEY `package_id` (`package_id`),
  KEY `sales_tax_code_id` (`sales_tax_code_id`),
  KEY `account_number` (`account_number`),
  KEY `company_name` (`company_name`),
  CONSTRAINT `shopsuite_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`),
  CONSTRAINT `shopsuite_customers_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `shopsuite_customers_packages` (`package_id`),
  CONSTRAINT `shopsuite_customers_ibfk_3` FOREIGN KEY (`sales_tax_code_id`) REFERENCES `shopsuite_tax_codes` (`tax_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_customers`
--

LOCK TABLES `shopsuite_customers` WRITE;
/*!40000 ALTER TABLE `shopsuite_customers` DISABLE KEYS */;
INSERT INTO `shopsuite_customers` VALUES
(2,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 08:45:32',1,0),
(48,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(49,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(50,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(51,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(52,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(53,NULL,NULL,0,'',NULL,NULL,NULL,1,0.00,0,'2025-10-23 20:13:29',1,1),
(54,NULL,NULL,0,'',NULL,NULL,NULL,0,0.00,0,'2025-10-23 20:13:29',1,1),
(65,'','CUST001',1,'',NULL,NULL,150,0,0.00,0,'2025-10-24 14:18:16',1,0),
(66,'Smith Corp','CUST002',1,'TAX123',NULL,NULL,500,0,10.00,0,'2025-10-24 14:18:16',1,0),
(67,'','CUST003',1,'',NULL,NULL,75,0,0.00,0,'2025-10-24 14:18:16',1,0),
(68,'Williams LLC','CUST004',1,'TAX456',NULL,NULL,200,0,5.00,0,'2025-10-24 14:18:16',1,0),
(69,'Brown Wholesale','CUST005',1,'TAX789',NULL,NULL,1000,0,15.00,0,'2025-10-24 14:18:16',1,0),
(70,'','CUST006',1,'',NULL,NULL,50,0,0.00,0,'2025-10-24 14:18:16',1,0),
(71,'Lee Enterprises','CUST007',1,'TAX321',NULL,NULL,300,0,8.00,0,'2025-10-24 14:18:16',1,0),
(72,'','CUST008',1,'',NULL,NULL,125,0,0.00,0,'2025-10-24 14:18:16',1,0),
(73,'','CUST009',1,'',NULL,NULL,90,0,0.00,0,'2025-10-24 14:18:16',1,0),
(74,'Martinez Trading','CUST010',1,'TAX654',NULL,NULL,600,0,12.00,0,'2025-10-24 14:18:16',1,0);
/*!40000 ALTER TABLE `shopsuite_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_customers_packages`
--

DROP TABLE IF EXISTS `shopsuite_customers_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_customers_packages` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) DEFAULT NULL,
  `points_percent` float NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_customers_packages`
--

LOCK TABLES `shopsuite_customers_packages` WRITE;
/*!40000 ALTER TABLE `shopsuite_customers_packages` DISABLE KEYS */;
INSERT INTO `shopsuite_customers_packages` VALUES
(1,'Default',0,0),
(2,'Bronze',10,0),
(3,'Silver',20,0),
(4,'Gold',30,0),
(5,'Premium',50,0);
/*!40000 ALTER TABLE `shopsuite_customers_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_customers_points`
--

DROP TABLE IF EXISTS `shopsuite_customers_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_customers_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `package_id` (`package_id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `shopsuite_customers_points_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_customers` (`person_id`),
  CONSTRAINT `shopsuite_customers_points_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `shopsuite_customers_packages` (`package_id`),
  CONSTRAINT `shopsuite_customers_points_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_customers_points`
--

LOCK TABLES `shopsuite_customers_points` WRITE;
/*!40000 ALTER TABLE `shopsuite_customers_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_customers_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_dinner_tables`
--

DROP TABLE IF EXISTS `shopsuite_dinner_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_dinner_tables` (
  `dinner_table_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dinner_table_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_dinner_tables`
--

LOCK TABLES `shopsuite_dinner_tables` WRITE;
/*!40000 ALTER TABLE `shopsuite_dinner_tables` DISABLE KEYS */;
INSERT INTO `shopsuite_dinner_tables` VALUES
(1,'Delivery',0,0),
(2,'Take Away',0,0);
/*!40000 ALTER TABLE `shopsuite_dinner_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_employees`
--

DROP TABLE IF EXISTS `shopsuite_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `hash_version` tinyint(1) NOT NULL DEFAULT 2,
  `language` varchar(48) DEFAULT NULL,
  `language_code` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT `shopsuite_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_employees`
--

LOCK TABLES `shopsuite_employees` WRITE;
/*!40000 ALTER TABLE `shopsuite_employees` DISABLE KEYS */;
INSERT INTO `shopsuite_employees` VALUES
('admin','$2y$10$p9RxurlQO.3mRBfz5cKVjutdn2SPHgQ2r2uAeFbRpaedxF5BEmidO',1,0,2,NULL,NULL);
/*!40000 ALTER TABLE `shopsuite_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_expense_categories`
--

DROP TABLE IF EXISTS `shopsuite_expense_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_expense_categories` (
  `expense_category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `category_description` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`expense_category_id`),
  UNIQUE KEY `category_name` (`category_name`),
  KEY `category_description` (`category_description`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_expense_categories`
--

LOCK TABLES `shopsuite_expense_categories` WRITE;
/*!40000 ALTER TABLE `shopsuite_expense_categories` DISABLE KEYS */;
INSERT INTO `shopsuite_expense_categories` VALUES
(15,'Rent','Monthly store rent',0),
(16,'Utilities','Electricity water internet',0),
(17,'Salaries','Employee wages',0),
(18,'Marketing','Advertising and promotions',0);
/*!40000 ALTER TABLE `shopsuite_expense_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_expenses`
--

DROP TABLE IF EXISTS `shopsuite_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_expenses` (
  `expense_id` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `amount` decimal(15,2) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `supplier_tax_code` varchar(255) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `supplier_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`expense_id`),
  KEY `expense_category_id` (`expense_category_id`),
  KEY `employee_id` (`employee_id`),
  KEY `date` (`date`),
  KEY `payment_type` (`payment_type`),
  KEY `amount` (`amount`),
  KEY `shopsuite_expenses_ibfk_3` (`supplier_id`),
  CONSTRAINT `shopsuite_expenses_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `shopsuite_expense_categories` (`expense_category_id`),
  CONSTRAINT `shopsuite_expenses_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
  CONSTRAINT `shopsuite_expenses_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_expenses`
--

LOCK TABLES `shopsuite_expenses` WRITE;
/*!40000 ALTER TABLE `shopsuite_expenses` DISABLE KEYS */;
INSERT INTO `shopsuite_expenses` VALUES
(11,'2025-10-23 14:30:18',285.00,'Bank Transfer',16,'Monthly electricity bill',1,0,NULL,NULL,NULL),
(12,'2025-10-22 14:30:18',2500.00,'Check',15,'Store rent for current month',1,0,NULL,NULL,NULL),
(13,'2025-10-17 14:30:18',450.00,'Credit Card',18,'Digital marketing campaign',1,0,NULL,NULL,NULL),
(14,'2025-10-14 14:30:18',4200.00,'Bank Transfer',17,'Staff monthly salaries',1,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `shopsuite_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_giftcards`
--

DROP TABLE IF EXISTS `shopsuite_giftcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_giftcards` (
  `record_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(255) DEFAULT NULL,
  `value` decimal(15,2) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `person_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `shopsuite_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_giftcards`
--

LOCK TABLES `shopsuite_giftcards` WRITE;
/*!40000 ALTER TABLE `shopsuite_giftcards` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_giftcards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_grants`
--

DROP TABLE IF EXISTS `shopsuite_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_grants` (
  `permission_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `menu_group` varchar(32) DEFAULT 'home',
  PRIMARY KEY (`permission_id`,`person_id`),
  KEY `shopsuite_grants_ibfk_2` (`person_id`),
  CONSTRAINT `shopsuite_grants_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `shopsuite_permissions` (`permission_id`) ON DELETE CASCADE,
  CONSTRAINT `shopsuite_grants_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_employees` (`person_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_grants`
--

LOCK TABLES `shopsuite_grants` WRITE;
/*!40000 ALTER TABLE `shopsuite_grants` DISABLE KEYS */;
INSERT INTO `shopsuite_grants` VALUES
('attributes',1,'both'),
('attributes_add',1,'both'),
('attributes_delete',1,'both'),
('attributes_update',1,'both'),
('attributes_view',1,'both'),
('backups',1,'both'),
('backups_create',1,'both'),
('backups_delete',1,'both'),
('backups_download',1,'both'),
('backups_restore',1,'both'),
('backups_view',1,'both'),
('cashups',1,'home'),
('cashups_add',1,'both'),
('cashups_delete',1,'both'),
('cashups_update',1,'both'),
('cashups_view',1,'both'),
('config',1,'both'),
('config_backup',1,'both'),
('config_update',1,'both'),
('config_view',1,'both'),
('customers',1,'home'),
('customers_add',1,'both'),
('customers_delete',1,'both'),
('customers_export',1,'both'),
('customers_update',1,'both'),
('customers_view',1,'both'),
('employees',1,'both'),
('employees_add',1,'both'),
('employees_delete',1,'both'),
('employees_manage_permissions',1,'both'),
('employees_update',1,'both'),
('employees_view',1,'both'),
('expenses',1,'home'),
('expenses_add',1,'both'),
('expenses_categories',1,'both'),
('expenses_categories_add',1,'both'),
('expenses_categories_delete',1,'both'),
('expenses_categories_update',1,'both'),
('expenses_categories_view',1,'both'),
('expenses_delete',1,'both'),
('expenses_update',1,'both'),
('expenses_view',1,'both'),
('giftcards',1,'home'),
('giftcards_add',1,'both'),
('giftcards_delete',1,'both'),
('giftcards_update',1,'both'),
('giftcards_view',1,'both'),
('home',1,'both'),
('items',1,'home'),
('items_add',1,'both'),
('items_delete',1,'both'),
('items_export',1,'both'),
('items_manage_stock',1,'both'),
('items_stock',1,'home'),
('items_update',1,'both'),
('items_view',1,'both'),
('item_kits',1,'home'),
('messages',1,'home'),
('messages_delete',1,'both'),
('messages_send',1,'both'),
('messages_view',1,'both'),
('office',1,'home'),
('receivings',1,'home'),
('receivings_add',1,'both'),
('receivings_delete',1,'both'),
('receivings_stock',1,'home'),
('receivings_update',1,'both'),
('receivings_view',1,'both'),
('reports',1,'home'),
('reports_categories',1,'home'),
('reports_customers',1,'home'),
('reports_discounts',1,'home'),
('reports_employees',1,'home'),
('reports_expenses_categories',1,'home'),
('reports_export',1,'both'),
('reports_inventory',1,'home'),
('reports_items',1,'home'),
('reports_payments',1,'home'),
('reports_receivings',1,'home'),
('reports_sales',1,'home'),
('reports_sales_taxes',1,'home'),
('reports_suppliers',1,'home'),
('reports_taxes',1,'home'),
('reports_view',1,'both'),
('roles',1,'both'),
('roles_add',1,'both'),
('roles_delete',1,'both'),
('roles_update',1,'both'),
('roles_view',1,'both'),
('sales',1,'home'),
('sales_add',1,'both'),
('sales_change_price',1,'--'),
('sales_delete',1,'--'),
('sales_export',1,'both'),
('sales_refund',1,'both'),
('sales_stock',1,'home'),
('sales_update',1,'both'),
('sales_view',1,'both'),
('suppliers',1,'home'),
('suppliers_add',1,'both'),
('suppliers_delete',1,'both'),
('suppliers_export',1,'both'),
('suppliers_update',1,'both'),
('suppliers_view',1,'both'),
('taxes',1,'both'),
('taxes_add',1,'both'),
('taxes_delete',1,'both'),
('taxes_update',1,'both'),
('taxes_view',1,'both');
/*!40000 ALTER TABLE `shopsuite_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_inventory`
--

DROP TABLE IF EXISTS `shopsuite_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT 0,
  `trans_user` int(11) NOT NULL DEFAULT 0,
  `trans_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `trans_comment` text NOT NULL,
  `trans_location` int(11) NOT NULL,
  `trans_inventory` decimal(15,3) NOT NULL DEFAULT 0.000,
  PRIMARY KEY (`trans_id`),
  KEY `trans_items` (`trans_items`),
  KEY `trans_user` (`trans_user`),
  KEY `trans_location` (`trans_location`),
  KEY `trans_date` (`trans_date`),
  KEY `trans_items_trans_date` (`trans_items`,`trans_date`),
  CONSTRAINT `shopsuite_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `shopsuite_items` (`item_id`),
  CONSTRAINT `shopsuite_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `shopsuite_employees` (`person_id`),
  CONSTRAINT `shopsuite_inventory_ibfk_3` FOREIGN KEY (`trans_location`) REFERENCES `shopsuite_stock_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_inventory`
--

LOCK TABLES `shopsuite_inventory` WRITE;
/*!40000 ALTER TABLE `shopsuite_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_item_kit_items`
--

DROP TABLE IF EXISTS `shopsuite_item_kit_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `kit_sequence` int(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `shopsuite_item_kit_items_ibfk_2` (`item_id`),
  CONSTRAINT `shopsuite_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `shopsuite_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  CONSTRAINT `shopsuite_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_item_kit_items`
--

LOCK TABLES `shopsuite_item_kit_items` WRITE;
/*!40000 ALTER TABLE `shopsuite_item_kit_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_item_kit_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_item_kits`
--

DROP TABLE IF EXISTS `shopsuite_item_kits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT 0,
  `kit_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kit_discount_type` tinyint(1) NOT NULL DEFAULT 0,
  `price_option` tinyint(1) NOT NULL DEFAULT 0,
  `print_option` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`item_kit_id`),
  KEY `item_kit_number` (`item_kit_number`),
  KEY `name` (`name`,`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_item_kits`
--

LOCK TABLES `shopsuite_item_kits` WRITE;
/*!40000 ALTER TABLE `shopsuite_item_kits` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_item_kits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_item_quantities`
--

DROP TABLE IF EXISTS `shopsuite_item_quantities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_item_quantities` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL DEFAULT 0.000,
  PRIMARY KEY (`item_id`,`location_id`),
  KEY `item_id` (`item_id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `shopsuite_item_quantities_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
  CONSTRAINT `shopsuite_item_quantities_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `shopsuite_stock_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_item_quantities`
--

LOCK TABLES `shopsuite_item_quantities` WRITE;
/*!40000 ALTER TABLE `shopsuite_item_quantities` DISABLE KEYS */;
INSERT INTO `shopsuite_item_quantities` VALUES
(43,1,18.000),
(44,1,24.000),
(45,1,65.000),
(46,1,32.000),
(47,1,14.000),
(48,1,8.000),
(49,1,45.000),
(50,1,180.000),
(51,1,250.000),
(52,1,95.000),
(53,1,38.000),
(54,1,85.000),
(55,1,30.000),
(56,1,92.000),
(57,1,55.000);
/*!40000 ALTER TABLE `shopsuite_item_quantities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_items`
--

DROP TABLE IF EXISTS `shopsuite_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `reorder_level` decimal(15,3) NOT NULL DEFAULT 0.000,
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT 1.000,
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `pic_filename` varchar(255) DEFAULT NULL,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `stock_type` tinyint(1) NOT NULL DEFAULT 0,
  `item_type` tinyint(1) NOT NULL DEFAULT 0,
  `tax_category_id` int(10) DEFAULT NULL,
  `qty_per_pack` decimal(15,3) NOT NULL DEFAULT 1.000,
  `pack_name` varchar(8) DEFAULT 'Each',
  `low_sell_item_id` int(10) DEFAULT 0,
  `hsn_code` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `items_uq1` (`supplier_id`,`item_id`,`deleted`,`item_type`),
  KEY `supplier_id` (`supplier_id`),
  KEY `item_number` (`item_number`),
  KEY `deleted` (`deleted`,`item_type`),
  KEY `item_id` (`item_id`,`deleted`),
  CONSTRAINT `shopsuite_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_items`
--

LOCK TABLES `shopsuite_items` WRITE;
/*!40000 ALTER TABLE `shopsuite_items` DISABLE KEYS */;
INSERT INTO `shopsuite_items` VALUES
('Laptop Computer','Electronics',120,'ELEC-001','Business Laptop 15.6 inch',450.00,899.99,5.000,10.000,43,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Monitor 24 inch','Electronics',120,'ELEC-002','Full HD IPS Monitor',120.00,249.99,8.000,15.000,44,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Wireless Mouse','Electronics',120,'ELEC-003','Ergonomic Wireless Mouse',12.00,29.99,25.000,50.000,45,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Mechanical Keyboard','Electronics',120,'ELEC-004','RGB Mechanical Keyboard',45.00,99.99,15.000,30.000,46,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Office Chair','Furniture',121,'FURN-001','Ergonomic Office Chair',150.00,349.99,5.000,10.000,47,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Standing Desk','Furniture',121,'FURN-002','Height Adjustable Desk',280.00,599.99,3.000,8.000,48,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Desk Lamp LED','Furniture',121,'FURN-003','Adjustable LED Desk Lamp',18.00,44.99,20.000,40.000,49,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Notebook Pack','Stationery',121,'STAT-001','Pack of 5 Notebooks',6.00,14.99,50.000,100.000,50,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Premium Pen Set','Stationery',121,'STAT-002','Premium Pen Set 12pcs',4.50,12.99,80.000,150.000,51,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('USB Flash Drive','Electronics',120,'ELEC-005','64GB USB 3.0',8.00,24.99,40.000,80.000,52,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Bluetooth Headphones','Electronics',120,'ELEC-006','Noise Canceling Wireless',38.00,79.99,15.000,30.000,53,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Water Bottle','Accessories',122,'ACC-001','Stainless Steel Bottle',9.00,22.99,30.000,60.000,54,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Laptop Backpack','Accessories',122,'ACC-002','Backpack with USB Port',28.00,64.99,12.000,25.000,55,NULL,1,0,0,0,0,1,1.000,'Each',0,''),
('Phone Holder','Accessories',122,'ACC-003','Adjustable Desk Holder',7.00,16.99,35.000,70.000,56,NULL,0,0,0,0,0,1,1.000,'Each',0,''),
('Desk Mat XL','Accessories',122,'ACC-004','Extra Large Desk Mat',12.00,29.99,20.000,40.000,57,NULL,0,0,0,0,0,1,1.000,'Each',0,'');
/*!40000 ALTER TABLE `shopsuite_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_items_taxes`
--

DROP TABLE IF EXISTS `shopsuite_items_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`),
  CONSTRAINT `shopsuite_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_items_taxes`
--

LOCK TABLES `shopsuite_items_taxes` WRITE;
/*!40000 ALTER TABLE `shopsuite_items_taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_items_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_migrations`
--

DROP TABLE IF EXISTS `shopsuite_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_migrations`
--

LOCK TABLES `shopsuite_migrations` WRITE;
/*!40000 ALTER TABLE `shopsuite_migrations` DISABLE KEYS */;
INSERT INTO `shopsuite_migrations` VALUES
(1,'20170501150000','App\\Database\\Migrations\\Migration_Upgrade_To_3_1_1','development','App',1761235063,1),
(2,'20170502221506','App\\Database\\Migrations\\Migration_Sales_Tax_Data','development','App',1761235063,1),
(3,'20180225100000','App\\Database\\Migrations\\Migration_Upgrade_To_3_2_0','development','App',1761235064,1),
(4,'20180501100000','App\\Database\\Migrations\\Migration_Upgrade_To_3_2_1','development','App',1761235064,1),
(5,'20181015100000','App\\Database\\Migrations\\Migration_Attributes','development','App',1761235064,1),
(6,'20190111270000','App\\Database\\Migrations\\Migration_Upgrade_To_3_3_0','development','App',1761235065,1),
(7,'20190129212600','App\\Database\\Migrations\\Migration_IndiaGST','development','App',1761235066,1),
(8,'20190213210000','App\\Database\\Migrations\\Migration_IndiaGST1','development','App',1761235066,1),
(9,'20190220210000','App\\Database\\Migrations\\Migration_IndiaGST2','development','App',1761235066,1),
(10,'20190301124900','App\\Database\\Migrations\\Migration_decimal_attribute_type','development','App',1761235066,1),
(11,'20190317102600','App\\Database\\Migrations\\Migration_add_iso_4217','development','App',1761235066,1),
(12,'20190427100000','App\\Database\\Migrations\\Migration_PaymentTracking','development','App',1761235066,1),
(13,'20190502100000','App\\Database\\Migrations\\Migration_RefundTracking','development','App',1761235066,1),
(14,'20190612100000','App\\Database\\Migrations\\Migration_DBFix','development','App',1761235067,1),
(15,'20190615100000','App\\Database\\Migrations\\Migration_fix_attribute_datetime','development','App',1761235067,1),
(16,'20190712150200','App\\Database\\Migrations\\Migration_fix_empty_reports','development','App',1761235067,1),
(17,'20191008100000','App\\Database\\Migrations\\Migration_receipttaxindicator','development','App',1761235067,1),
(18,'20191231100000','App\\Database\\Migrations\\Migration_PaymentDateFix','development','App',1761235067,1),
(19,'20200125100000','App\\Database\\Migrations\\Migration_SalesChangePrice','development','App',1761235067,1),
(20,'20200202000000','App\\Database\\Migrations\\Migration_TaxAmount','development','App',1761235067,1),
(21,'20200215100000','App\\Database\\Migrations\\Migration_taxgroupconstraint','development','App',1761235067,1),
(22,'20200508000000','App\\Database\\Migrations\\Migration_image_upload_defaults','development','App',1761235067,1),
(23,'20200819000000','App\\Database\\Migrations\\Migration_modify_attr_links_constraint','development','App',1761235067,1),
(24,'20201108100000','App\\Database\\Migrations\\Migration_cashrounding','development','App',1761235067,1),
(25,'20201110000000','App\\Database\\Migrations\\Migration_add_item_kit_number','development','App',1761235067,1),
(26,'20210103000000','App\\Database\\Migrations\\Migration_modify_session_datatype','development','App',1761235067,1),
(27,'20210422000000','App\\Database\\Migrations\\Migration_database_optimizations','development','App',1761235072,1),
(28,'20210422000001','App\\Database\\Migrations\\Migration_remove_duplicate_links','development','App',1761235072,1),
(29,'20210714140000','App\\Database\\Migrations\\Migration_move_expenses_categories','development','App',1761235072,1),
(30,'20220127000000','App\\Database\\Migrations\\Convert_to_ci4','development','App',1761235072,1),
(31,'20230307000000','App\\Database\\Migrations\\IntToTinyint','development','App',1761235073,1),
(32,'20230412000000','App\\Database\\Migrations\\Migration_add_missing_config','development','App',1761235073,1),
(33,'20230412000001','App\\Database\\Migrations\\Migration_drop_account_number_index','development','App',1761235073,1),
(34,'20240319000000','App\\Database\\Migrations\\Migration_Convert_Barcode_Types','development','App',1761235073,1),
(35,'20240630000001','App\\Database\\Migrations\\Migration_fix_keys_for_db_upgrade','development','App',1761235073,1),
(36,'20240826000000','App\\Database\\Migrations\\fix_duplicate_attributes','development','App',1761235074,1),
(37,'20250213000000','App\\Database\\Migrations\\Migration_Attributes_fix_cascading_delete','development','App',1761235074,1),
(38,'20250425000000','App\\Database\\Migrations\\Migration_sessions_migration','development','App',1761235074,1),
(39,'20250519000000','App\\Database\\Migrations\\MigrationOptimizationIndices','development','App',1761235075,1),
(40,'20250522000000','App\\Database\\Migrations\\AttributeLinksUniqueConstraint','development','App',1761235075,1),
(41,'20250716170000','App\\Database\\Migrations\\Migration_MissingConfigKeys','development','App',1761235075,1),
(42,'20250729170000','App\\Database\\Migrations\\Migration_NullableTaxCategoryId','development','App',1761235075,1);
/*!40000 ALTER TABLE `shopsuite_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_modules`
--

DROP TABLE IF EXISTS `shopsuite_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_modules`
--

LOCK TABLES `shopsuite_modules` WRITE;
/*!40000 ALTER TABLE `shopsuite_modules` DISABLE KEYS */;
INSERT INTO `shopsuite_modules` VALUES
('module_attributes','module_attributes_desc',107,'attributes'),
('module_backups','module_backups_desc',116,'backups'),
('module_cashups','module_cashups_desc',110,'cashups'),
('module_config','module_config_desc',900,'config'),
('module_customers','module_customers_desc',10,'customers'),
('module_employees','module_employees_desc',80,'employees'),
('module_expenses','module_expenses_desc',108,'expenses'),
('module_expenses_categories','module_expenses_categories_desc',109,'expenses_categories'),
('module_giftcards','module_giftcards_desc',90,'giftcards'),
('module_home','module_home_desc',1,'home'),
('module_items','module_items_desc',20,'items'),
('module_item_kits','module_item_kits_desc',30,'item_kits'),
('module_messages','module_messages_desc',98,'messages'),
('module_office','module_office_desc',999,'office'),
('module_receivings','module_receivings_desc',60,'receivings'),
('module_reports','module_reports_desc',50,'reports'),
('module_roles','module_roles_desc',115,'roles'),
('module_sales','module_sales_desc',70,'sales'),
('module_suppliers','module_suppliers_desc',40,'suppliers'),
('module_taxes','module_taxes_desc',105,'taxes');
/*!40000 ALTER TABLE `shopsuite_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_people`
--

DROP TABLE IF EXISTS `shopsuite_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`),
  KEY `email` (`email`),
  KEY `first_name` (`first_name`,`last_name`,`email`,`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_people`
--

LOCK TABLES `shopsuite_people` WRITE;
/*!40000 ALTER TABLE `shopsuite_people` DISABLE KEYS */;
INSERT INTO `shopsuite_people` VALUES
('John','Doe',NULL,'555-555-5555','changeme@example.com','Address 1','','','','','','',1),
('','',NULL,'','','','','','','','','',2),
('Md. Al-Amin','Mojumder',NULL,'01764414949','amin252646@gmail.com','narionshar','','Dhaka',' khilkhat','1229','Bangladesh','',3),
('Tech','Dist',1,'555-2001','sales@techdist.com','100 Tech','','Austin','TX','78701','USA','',120),
('Office','WS',1,'555-2002','orders@officews.com','200 Commerce','','Seattle','WA','98101','USA','',121),
('Access','Plus',1,'555-2003','info@accessplus.com','300 Market','','SF','CA','94102','USA','',122);
/*!40000 ALTER TABLE `shopsuite_people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_permissions`
--

DROP TABLE IF EXISTS `shopsuite_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_permissions` (
  `permission_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `location_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `module_id` (`module_id`),
  KEY `shopsuite_permissions_ibfk_2` (`location_id`),
  CONSTRAINT `shopsuite_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `shopsuite_modules` (`module_id`) ON DELETE CASCADE,
  CONSTRAINT `shopsuite_permissions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `shopsuite_stock_locations` (`location_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_permissions`
--

LOCK TABLES `shopsuite_permissions` WRITE;
/*!40000 ALTER TABLE `shopsuite_permissions` DISABLE KEYS */;
INSERT INTO `shopsuite_permissions` VALUES
('attributes','attributes',NULL),
('attributes_add','attributes',NULL),
('attributes_delete','attributes',NULL),
('attributes_update','attributes',NULL),
('attributes_view','attributes',NULL),
('backups','backups',NULL),
('backups_create','backups',NULL),
('backups_delete','backups',NULL),
('backups_download','backups',NULL),
('backups_restore','backups',NULL),
('backups_view','backups',NULL),
('cashups','cashups',NULL),
('cashups_add','cashups',NULL),
('cashups_delete','cashups',NULL),
('cashups_update','cashups',NULL),
('cashups_view','cashups',NULL),
('config','config',NULL),
('config_backup','config',NULL),
('config_update','config',NULL),
('config_view','config',NULL),
('customers','customers',NULL),
('customers_add','customers',NULL),
('customers_delete','customers',NULL),
('customers_export','customers',NULL),
('customers_update','customers',NULL),
('customers_view','customers',NULL),
('employees','employees',NULL),
('employees_add','employees',NULL),
('employees_delete','employees',NULL),
('employees_manage_permissions','employees',NULL),
('employees_update','employees',NULL),
('employees_view','employees',NULL),
('expenses','expenses',NULL),
('expenses_add','expenses',NULL),
('expenses_categories','expenses_categories',NULL),
('expenses_categories_add','expenses_categories',NULL),
('expenses_categories_delete','expenses_categories',NULL),
('expenses_categories_update','expenses_categories',NULL),
('expenses_categories_view','expenses_categories',NULL),
('expenses_delete','expenses',NULL),
('expenses_update','expenses',NULL),
('expenses_view','expenses',NULL),
('giftcards','giftcards',NULL),
('giftcards_add','giftcards',NULL),
('giftcards_delete','giftcards',NULL),
('giftcards_update','giftcards',NULL),
('giftcards_view','giftcards',NULL),
('home','home',NULL),
('items','items',NULL),
('items_add','items',NULL),
('items_delete','items',NULL),
('items_export','items',NULL),
('items_manage_stock','items',NULL),
('items_stock','items',1),
('items_update','items',NULL),
('items_view','items',NULL),
('item_kits','item_kits',NULL),
('messages','messages',NULL),
('messages_delete','messages',NULL),
('messages_send','messages',NULL),
('messages_view','messages',NULL),
('office','office',NULL),
('receivings','receivings',NULL),
('receivings_add','receivings',NULL),
('receivings_delete','receivings',NULL),
('receivings_stock','receivings',1),
('receivings_update','receivings',NULL),
('receivings_view','receivings',NULL),
('reports','reports',NULL),
('reports_categories','reports',NULL),
('reports_customers','reports',NULL),
('reports_discounts','reports',NULL),
('reports_employees','reports',NULL),
('reports_expenses_categories','reports',NULL),
('reports_export','reports',NULL),
('reports_inventory','reports',NULL),
('reports_items','reports',NULL),
('reports_payments','reports',NULL),
('reports_receivings','reports',NULL),
('reports_sales','reports',NULL),
('reports_sales_taxes','reports',NULL),
('reports_suppliers','reports',NULL),
('reports_taxes','reports',NULL),
('reports_view','reports',NULL),
('roles','roles',NULL),
('roles_add','roles',NULL),
('roles_delete','roles',NULL),
('roles_update','roles',NULL),
('roles_view','roles',NULL),
('sales','sales',NULL),
('sales_add','sales',NULL),
('sales_change_price','sales',NULL),
('sales_delete','sales',NULL),
('sales_export','sales',NULL),
('sales_refund','sales',NULL),
('sales_stock','sales',1),
('sales_update','sales',NULL),
('sales_view','sales',NULL),
('suppliers','suppliers',NULL),
('suppliers_add','suppliers',NULL),
('suppliers_delete','suppliers',NULL),
('suppliers_export','suppliers',NULL),
('suppliers_update','suppliers',NULL),
('suppliers_view','suppliers',NULL),
('taxes','taxes',NULL),
('taxes_add','taxes',NULL),
('taxes_delete','taxes',NULL),
('taxes_update','taxes',NULL),
('taxes_view','taxes',NULL);
/*!40000 ALTER TABLE `shopsuite_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_receivings`
--

DROP TABLE IF EXISTS `shopsuite_receivings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT 0,
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  `reference` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  KEY `reference` (`reference`),
  KEY `receiving_time` (`receiving_time`),
  CONSTRAINT `shopsuite_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
  CONSTRAINT `shopsuite_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `shopsuite_suppliers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_receivings`
--

LOCK TABLES `shopsuite_receivings` WRITE;
/*!40000 ALTER TABLE `shopsuite_receivings` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_receivings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_receivings_items`
--

DROP TABLE IF EXISTS `shopsuite_receivings_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT 0,
  `item_id` int(10) NOT NULL DEFAULT 0,
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT 0.000,
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_type` tinyint(1) NOT NULL DEFAULT 0,
  `item_location` int(11) NOT NULL,
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT 1.000,
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `shopsuite_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
  CONSTRAINT `shopsuite_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `shopsuite_receivings` (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_receivings_items`
--

LOCK TABLES `shopsuite_receivings_items` WRITE;
/*!40000 ALTER TABLE `shopsuite_receivings_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_receivings_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_role_permissions`
--

DROP TABLE IF EXISTS `shopsuite_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_role_permissions` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` varchar(255) NOT NULL,
  `menu_group` varchar(32) NOT NULL DEFAULT 'home',
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_role_permissions`
--

LOCK TABLES `shopsuite_role_permissions` WRITE;
/*!40000 ALTER TABLE `shopsuite_role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_roles`
--

DROP TABLE IF EXISTS `shopsuite_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_roles` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `role_description` text DEFAULT NULL,
  `is_system_role` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_roles`
--

LOCK TABLES `shopsuite_roles` WRITE;
/*!40000 ALTER TABLE `shopsuite_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales`
--

DROP TABLE IF EXISTS `shopsuite_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales` (
  `sale_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT 0,
  `comment` text NOT NULL,
  `invoice_number` varchar(32) DEFAULT NULL,
  `dinner_table_id` int(11) DEFAULT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `quote_number` varchar(32) DEFAULT NULL,
  `sale_status` tinyint(1) NOT NULL DEFAULT 0,
  `work_order_number` varchar(32) DEFAULT NULL,
  `sale_type` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sale_id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `sale_time` (`sale_time`),
  KEY `dinner_table_id` (`dinner_table_id`),
  CONSTRAINT `shopsuite_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`),
  CONSTRAINT `shopsuite_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `shopsuite_customers` (`person_id`),
  CONSTRAINT `shopsuite_sales_ibfk_3` FOREIGN KEY (`dinner_table_id`) REFERENCES `shopsuite_dinner_tables` (`dinner_table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales`
--

LOCK TABLES `shopsuite_sales` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales` DISABLE KEYS */;
INSERT INTO `shopsuite_sales` VALUES
('2025-10-24 14:30:18',65,1,'Walk-in customer','INV001',NULL,6,NULL,0,NULL,0),
('2025-10-23 14:30:18',66,1,'VIP Corporate order','INV002',NULL,7,NULL,0,NULL,0),
('2025-10-22 14:30:18',67,1,'Regular purchase','INV003',NULL,8,NULL,0,NULL,0),
('2025-10-21 14:30:18',68,1,'Bulk order discount applied','INV004',NULL,9,NULL,0,NULL,0),
('2025-10-19 14:30:18',69,1,'Wholesale customer','INV005',NULL,10,NULL,0,NULL,0);
/*!40000 ALTER TABLE `shopsuite_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales_items`
--

DROP TABLE IF EXISTS `shopsuite_sales_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT 0,
  `item_id` int(10) NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT 0,
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT 0.000,
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_type` tinyint(1) NOT NULL DEFAULT 0,
  `item_location` int(11) NOT NULL,
  `print_option` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`),
  KEY `item_location` (`item_location`),
  CONSTRAINT `shopsuite_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`),
  CONSTRAINT `shopsuite_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`),
  CONSTRAINT `shopsuite_sales_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `shopsuite_stock_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales_items`
--

LOCK TABLES `shopsuite_sales_items` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales_items` DISABLE KEYS */;
INSERT INTO `shopsuite_sales_items` VALUES
(6,43,'Laptop','',1,1.000,450.00,899.99,0.00,0,1,0),
(6,45,'Mouse','',2,1.000,12.00,29.99,0.00,0,1,0),
(7,43,'Laptops','',1,3.000,450.00,899.99,10.00,0,1,0),
(7,44,'Monitors','',2,3.000,120.00,249.99,10.00,0,1,0),
(8,50,'Notebooks','',1,15.000,6.00,14.99,0.00,0,1,0),
(8,51,'Pens','',2,25.000,4.50,12.99,0.00,0,1,0),
(9,47,'Chairs','',1,2.000,150.00,349.99,5.00,0,1,0),
(9,48,'Desk','',2,1.000,280.00,599.99,5.00,0,1,0),
(10,50,'Notebooks','',1,50.000,6.00,14.99,15.00,0,1,0),
(10,51,'Pens','',2,80.000,4.50,12.99,15.00,0,1,0);
/*!40000 ALTER TABLE `shopsuite_sales_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales_items_taxes`
--

DROP TABLE IF EXISTS `shopsuite_sales_items_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `tax_type` tinyint(1) NOT NULL DEFAULT 0,
  `rounding_code` tinyint(1) NOT NULL DEFAULT 0,
  `cascade_sequence` tinyint(1) NOT NULL DEFAULT 0,
  `item_tax_amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `sales_tax_code_id` int(11) DEFAULT NULL,
  `jurisdiction_id` int(11) DEFAULT NULL,
  `tax_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `shopsuite_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`, `item_id`, `line`) REFERENCES `shopsuite_sales_items` (`sale_id`, `item_id`, `line`),
  CONSTRAINT `shopsuite_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `shopsuite_items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales_items_taxes`
--

LOCK TABLES `shopsuite_sales_items_taxes` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales_items_taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_sales_items_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales_payments`
--

DROP TABLE IF EXISTS `shopsuite_sales_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `cash_refund` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cash_adjustment` tinyint(4) NOT NULL DEFAULT 0,
  `employee_id` int(11) DEFAULT NULL,
  `payment_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_code` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`payment_id`),
  KEY `payment_sale` (`sale_id`,`payment_type`),
  KEY `employee_id` (`employee_id`),
  KEY `payment_time` (`payment_time`),
  CONSTRAINT `shopsuite_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`),
  CONSTRAINT `shopsuite_sales_payments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `shopsuite_employees` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales_payments`
--

LOCK TABLES `shopsuite_sales_payments` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales_payments` DISABLE KEYS */;
INSERT INTO `shopsuite_sales_payments` VALUES
(1,6,'Cash',929.98,0.00,0,NULL,'2025-10-24 14:30:18',''),
(2,7,'Credit Card',3149.91,0.00,0,NULL,'2025-10-24 14:30:18',''),
(3,8,'Cash',549.60,0.00,0,NULL,'2025-10-24 14:30:18',''),
(4,9,'Check',1033.94,0.00,0,NULL,'2025-10-24 14:30:18',''),
(5,10,'Credit Card',1916.45,0.00,0,NULL,'2025-10-24 14:30:18','');
/*!40000 ALTER TABLE `shopsuite_sales_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales_reward_points`
--

DROP TABLE IF EXISTS `shopsuite_sales_reward_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales_reward_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `earned` float NOT NULL,
  `used` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `shopsuite_sales_reward_points_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `shopsuite_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales_reward_points`
--

LOCK TABLES `shopsuite_sales_reward_points` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales_reward_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_sales_reward_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sales_taxes`
--

DROP TABLE IF EXISTS `shopsuite_sales_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sales_taxes` (
  `sales_taxes_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(10) NOT NULL,
  `jurisdiction_id` int(11) DEFAULT NULL,
  `tax_category_id` int(11) DEFAULT NULL,
  `tax_type` smallint(2) NOT NULL,
  `tax_group` varchar(32) NOT NULL,
  `sale_tax_basis` decimal(15,4) NOT NULL,
  `sale_tax_amount` decimal(15,4) NOT NULL,
  `print_sequence` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL,
  `sales_tax_code_id` int(11) DEFAULT NULL,
  `rounding_code` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sales_taxes_id`),
  KEY `print_sequence` (`sale_id`,`print_sequence`,`tax_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sales_taxes`
--

LOCK TABLES `shopsuite_sales_taxes` WRITE;
/*!40000 ALTER TABLE `shopsuite_sales_taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_sales_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_sessions`
--

DROP TABLE IF EXISTS `shopsuite_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `shopsuite_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_sessions`
--

LOCK TABLES `shopsuite_sessions` WRITE;
/*!40000 ALTER TABLE `shopsuite_sessions` DISABLE KEYS */;
INSERT INTO `shopsuite_sessions` VALUES
('shopsuite_session:063ff4b9e8bfb6920b7964c4a1fa4a69','::1','2025-10-24 13:46:15','__ci_last_regenerate|i:1761313396;_ci_previous_url|s:26:\"http://localhost/suppliers\";person_id|s:1:\"1\";menu_group|s:4:\"home\";allow_temp_items|i:0;item_location|s:1:\"1\";'),
('shopsuite_session:5097d4eee6bcf766f35ec04fc4bc427e','::1','2025-10-24 14:33:00','__ci_last_regenerate|i:1761316304;_ci_previous_url|s:21:\"http://localhost/home\";person_id|s:1:\"1\";menu_group|s:4:\"home\";'),
('shopsuite_session:83aab5d93d07e7176e130bce0c24818f','::1','2025-10-24 12:36:36','__ci_last_regenerate|i:1761309396;_ci_previous_url|s:21:\"http://localhost/home\";person_id|s:1:\"1\";menu_group|s:4:\"home\";'),
('shopsuite_session:c43ce959b747f6f393c619b89447cf3d','::1','2025-10-24 13:59:47','__ci_last_regenerate|i:1761314175;_ci_previous_url|s:22:\"http://localhost/login\";person_id|s:1:\"1\";menu_group|s:4:\"home\";');
/*!40000 ALTER TABLE `shopsuite_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_stock_locations`
--

DROP TABLE IF EXISTS `shopsuite_stock_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_stock_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_stock_locations`
--

LOCK TABLES `shopsuite_stock_locations` WRITE;
/*!40000 ALTER TABLE `shopsuite_stock_locations` DISABLE KEYS */;
INSERT INTO `shopsuite_stock_locations` VALUES
(1,'stock',0);
/*!40000 ALTER TABLE `shopsuite_stock_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_suppliers`
--

DROP TABLE IF EXISTS `shopsuite_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `tax_id` varchar(32) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `category` tinyint(1) NOT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `category` (`category`),
  KEY `company_name` (`company_name`,`deleted`),
  CONSTRAINT `shopsuite_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `shopsuite_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_suppliers`
--

LOCK TABLES `shopsuite_suppliers` WRITE;
/*!40000 ALTER TABLE `shopsuite_suppliers` DISABLE KEYS */;
INSERT INTO `shopsuite_suppliers` VALUES
(120,'Tech Distributors','Tech','S001','T001',0,1),
(121,'Office Wholesale','Office','S002','T002',0,1),
(122,'Accessories Plus','Access','S003','T003',0,1);
/*!40000 ALTER TABLE `shopsuite_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_tax_categories`
--

DROP TABLE IF EXISTS `shopsuite_tax_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_tax_categories` (
  `tax_category_id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_category` varchar(32) NOT NULL,
  `tax_group_sequence` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tax_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_tax_categories`
--

LOCK TABLES `shopsuite_tax_categories` WRITE;
/*!40000 ALTER TABLE `shopsuite_tax_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_tax_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_tax_codes`
--

DROP TABLE IF EXISTS `shopsuite_tax_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_tax_codes` (
  `tax_code_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_code` varchar(32) NOT NULL,
  `tax_code_name` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tax_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_tax_codes`
--

LOCK TABLES `shopsuite_tax_codes` WRITE;
/*!40000 ALTER TABLE `shopsuite_tax_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_tax_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_tax_jurisdictions`
--

DROP TABLE IF EXISTS `shopsuite_tax_jurisdictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_tax_jurisdictions` (
  `jurisdiction_id` int(11) NOT NULL AUTO_INCREMENT,
  `jurisdiction_name` varchar(255) DEFAULT NULL,
  `tax_group` varchar(32) NOT NULL,
  `tax_type` smallint(2) NOT NULL,
  `reporting_authority` varchar(255) DEFAULT NULL,
  `tax_group_sequence` tinyint(1) NOT NULL DEFAULT 0,
  `cascade_sequence` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`jurisdiction_id`),
  UNIQUE KEY `tax_jurisdictions_uq1` (`tax_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_tax_jurisdictions`
--

LOCK TABLES `shopsuite_tax_jurisdictions` WRITE;
/*!40000 ALTER TABLE `shopsuite_tax_jurisdictions` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_tax_jurisdictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsuite_tax_rates`
--

DROP TABLE IF EXISTS `shopsuite_tax_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsuite_tax_rates` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_tax_code_id` int(11) NOT NULL,
  `rate_tax_category_id` int(10) NOT NULL,
  `rate_jurisdiction_id` int(11) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `tax_rounding_code` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tax_rate_id`),
  KEY `rate_tax_category_id` (`rate_tax_category_id`),
  KEY `rate_tax_code_id` (`rate_tax_code_id`),
  KEY `rate_jurisdiction_id` (`rate_jurisdiction_id`),
  CONSTRAINT `shopsuite_tax_rates_ibfk_1` FOREIGN KEY (`rate_tax_category_id`) REFERENCES `shopsuite_tax_categories` (`tax_category_id`),
  CONSTRAINT `shopsuite_tax_rates_ibfk_2` FOREIGN KEY (`rate_tax_code_id`) REFERENCES `shopsuite_tax_codes` (`tax_code_id`),
  CONSTRAINT `shopsuite_tax_rates_ibfk_3` FOREIGN KEY (`rate_jurisdiction_id`) REFERENCES `shopsuite_tax_jurisdictions` (`jurisdiction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsuite_tax_rates`
--

LOCK TABLES `shopsuite_tax_rates` WRITE;
/*!40000 ALTER TABLE `shopsuite_tax_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsuite_tax_rates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-24 20:34:17
