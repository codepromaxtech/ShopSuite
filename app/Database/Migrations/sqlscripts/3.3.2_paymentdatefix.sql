UPDATE `shopsuite_sales_payments`
  JOIN `shopsuite_sales` ON `shopsuite_sales`.`sale_id`=`shopsuite_sales_payments`.`sale_id`
  SET `shopsuite_sales_payments`.`payment_time`=`shopsuite_sales`.`sale_time`;
