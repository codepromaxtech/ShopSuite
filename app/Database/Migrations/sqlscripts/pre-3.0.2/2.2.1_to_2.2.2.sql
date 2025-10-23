ALTER TABLE shopsuite_giftcards MODIFY value decimal(15,2);

ALTER TABLE shopsuite_items MODIFY cost_price decimal(15,2);
ALTER TABLE shopsuite_items MODIFY unit_price decimal(15,2);
ALTER TABLE shopsuite_items MODIFY quantity decimal(15,0);
ALTER TABLE shopsuite_items MODIFY reorder_level decimal(15,0);

ALTER TABLE shopsuite_items_taxes MODIFY percent decimal(15,2);

ALTER TABLE shopsuite_item_kit_items MODIFY quantity decimal(15,0);

ALTER TABLE shopsuite_receivings_items MODIFY quantity_purchased decimal(15,0);
ALTER TABLE shopsuite_receivings_items MODIFY item_unit_price decimal(15,2);
ALTER TABLE shopsuite_receivings_items MODIFY discount_percent decimal(15,2);

ALTER TABLE shopsuite_sales_items_taxes MODIFY percent decimal(15,2);

ALTER TABLE shopsuite_sales_suspended_items MODIFY quantity_purchased decimal(15,0);
ALTER TABLE shopsuite_sales_suspended_items MODIFY item_unit_price decimal(15,2);
ALTER TABLE shopsuite_sales_suspended_items MODIFY discount_percent decimal(15,2);

ALTER TABLE shopsuite_sales_suspended_items_taxes MODIFY percent decimal(15,2);

ALTER TABLE shopsuite_sessions MODIFY ip_address varchar(45);
