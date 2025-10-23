-- Migration to make tax_category_id nullable in shopsuite_items
ALTER TABLE shopsuite_items
    MODIFY COLUMN tax_category_id INT NULL;
