INSERT INTO shopsuite_stock_locations (location_name) (SELECT DISTINCT(location) FROM shopsuite_items WHERE NOT EXISTS (select location from shopsuite_stock_locations where location_name = location));
INSERT INTO shopsuite_item_quantities (item_id, location_id, quantity) (SELECT item_id, location_id, quantity FROM shopsuite_items, shopsuite_stock_locations where shopsuite_items.location = shopsuite_stock_locations.location_name);
ALTER TABLE shopsuite_items DROP COLUMN location;
