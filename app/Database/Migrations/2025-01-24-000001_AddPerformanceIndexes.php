<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Add performance indexes for faster queries
 * Run with: php spark migrate
 */
class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // Customers table indexes
        if ($this->db->tableExists('customers')) {
            // Index on email for faster lookups
            $this->forge->addKey('email', false, false, 'idx_customers_email');
            
            // Index on company name for search
            $this->forge->addKey('company_name', false, false, 'idx_customers_company');
            
            // Composite index for active customers
            $this->forge->addKey(['deleted', 'person_id'], false, false, 'idx_customers_active');
            
            // Index on created date for recent queries
            if ($this->db->fieldExists('created_at', 'customers')) {
                $this->forge->addKey('created_at', false, false, 'idx_customers_created');
            }
        }
        
        // People table indexes (customers/suppliers/employees)
        if ($this->db->tableExists('people')) {
            // Index on first and last name
            $this->forge->addKey(['first_name', 'last_name'], false, false, 'idx_people_name');
            
            // Index on phone number
            $this->forge->addKey('phone_number', false, false, 'idx_people_phone');
        }
        
        // Sales table indexes
        if ($this->db->tableExists('sales')) {
            // Index on sale date for reports
            $this->forge->addKey('sale_time', false, false, 'idx_sales_time');
            
            // Index on customer for customer reports
            $this->forge->addKey('customer_id', false, false, 'idx_sales_customer');
            
            // Index on employee for employee reports
            $this->forge->addKey('employee_id', false, false, 'idx_sales_employee');
            
            // Composite index for date range queries
            $this->forge->addKey(['sale_time', 'customer_id'], false, false, 'idx_sales_time_customer');
        }
        
        // Items table indexes
        if ($this->db->tableExists('items')) {
            // Index on item name for search
            $this->forge->addKey('name', false, false, 'idx_items_name');
            
            // Index on category
            $this->forge->addKey('category', false, false, 'idx_items_category');
            
            // Index on item number/SKU
            if ($this->db->fieldExists('item_number', 'items')) {
                $this->forge->addKey('item_number', false, false, 'idx_items_number');
            }
            
            // Composite index for active items
            $this->forge->addKey(['deleted', 'item_id'], false, false, 'idx_items_active');
        }
        
        // Suppliers table indexes
        if ($this->db->tableExists('suppliers')) {
            // Index on company name
            $this->forge->addKey('company_name', false, false, 'idx_suppliers_company');
            
            // Index for active suppliers
            $this->forge->addKey(['deleted', 'person_id'], false, false, 'idx_suppliers_active');
        }
        
        // Giftcards table indexes
        if ($this->db->tableExists('giftcards')) {
            // Index on giftcard number
            $this->forge->addKey('giftcard_number', false, false, 'idx_giftcards_number');
            
            // Index on value for filtering
            $this->forge->addKey('value', false, false, 'idx_giftcards_value');
            
            // Composite index for active cards
            if ($this->db->fieldExists('deleted', 'giftcards')) {
                $this->forge->addKey(['deleted', 'giftcard_id'], false, false, 'idx_giftcards_active');
            }
        }
        
        // Inventory table indexes
        if ($this->db->tableExists('inventory')) {
            // Index on location
            $this->forge->addKey('location_id', false, false, 'idx_inventory_location');
            
            // Composite index for item at location
            $this->forge->addKey(['item_id', 'location_id'], false, false, 'idx_inventory_item_location');
        }
        
        echo "✅ Performance indexes added successfully\n";
    }

    public function down()
    {
        // Remove indexes if needed
        if ($this->db->tableExists('customers')) {
            $this->forge->dropKey('customers', 'idx_customers_email');
            $this->forge->dropKey('customers', 'idx_customers_company');
            $this->forge->dropKey('customers', 'idx_customers_active');
            if ($this->db->fieldExists('created_at', 'customers')) {
                $this->forge->dropKey('customers', 'idx_customers_created');
            }
        }
        
        if ($this->db->tableExists('people')) {
            $this->forge->dropKey('people', 'idx_people_name');
            $this->forge->dropKey('people', 'idx_people_phone');
        }
        
        if ($this->db->tableExists('sales')) {
            $this->forge->dropKey('sales', 'idx_sales_time');
            $this->forge->dropKey('sales', 'idx_sales_customer');
            $this->forge->dropKey('sales', 'idx_sales_employee');
            $this->forge->dropKey('sales', 'idx_sales_time_customer');
        }
        
        if ($this->db->tableExists('items')) {
            $this->forge->dropKey('items', 'idx_items_name');
            $this->forge->dropKey('items', 'idx_items_category');
            if ($this->db->fieldExists('item_number', 'items')) {
                $this->forge->dropKey('items', 'idx_items_number');
            }
            $this->forge->dropKey('items', 'idx_items_active');
        }
        
        if ($this->db->tableExists('suppliers')) {
            $this->forge->dropKey('suppliers', 'idx_suppliers_company');
            $this->forge->dropKey('suppliers', 'idx_suppliers_active');
        }
        
        if ($this->db->tableExists('giftcards')) {
            $this->forge->dropKey('giftcards', 'idx_giftcards_number');
            $this->forge->dropKey('giftcards', 'idx_giftcards_value');
            if ($this->db->fieldExists('deleted', 'giftcards')) {
                $this->forge->dropKey('giftcards', 'idx_giftcards_active');
            }
        }
        
        if ($this->db->tableExists('inventory')) {
            $this->forge->dropKey('inventory', 'idx_inventory_location');
            $this->forge->dropKey('inventory', 'idx_inventory_item_location');
        }
        
        echo "✅ Performance indexes removed\n";
    }
}
