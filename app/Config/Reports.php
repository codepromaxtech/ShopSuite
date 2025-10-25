<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Unified Reports Configuration
 * Defines all report categories, types, and their configurations
 */
class Reports extends BaseConfig
{
    /**
     * Report categories with their configurations
     * Each category has multiple report types that can be generated
     */
    public array $categories = [
        
        // ===== SALES REPORTS =====
        'sales' => [
            'title' => 'Sales Reports',
            'description' => 'Revenue and transaction analysis',
            'icon' => 'currency-dollar',
            'color' => '#10b981',
            'url' => 'reports/sales',
            
            'types' => [
                'summary' => [
                    'label' => 'Summary',
                    'description' => 'Sales summary by period',
                    'model' => 'Summary_sales',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'line', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'graph-up'
                ],
                'detailed' => [
                    'label' => 'Detailed',
                    'description' => 'Transaction-level details',
                    'model' => 'Detailed_sales',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => false,
                    'icon' => 'receipt'
                ],
                'payments' => [
                    'label' => 'Payments',
                    'description' => 'Payment methods breakdown',
                    'model' => 'Summary_payments',
                    'filters' => ['date_range'],
                    'supports_chart' => true,
                    'chart_types' => ['pie', 'bar'],
                    'default_chart' => 'pie',
                    'icon' => 'credit-card'
                ],
                'taxes' => [
                    'label' => 'Taxes',
                    'description' => 'Tax summary',
                    'model' => 'Summary_taxes',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'percent'
                ],
                'sales_taxes' => [
                    'label' => 'Sales Taxes',
                    'description' => 'Detailed sales tax breakdown',
                    'model' => 'Summary_sales_taxes',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'line'],
                    'default_chart' => 'bar',
                    'icon' => 'calculator'
                ]
            ]
        ],
        
        // ===== PRODUCT REPORTS =====
        'products' => [
            'title' => 'Product Reports',
            'description' => 'Inventory and product analysis',
            'icon' => 'box-seam-fill',
            'color' => '#6366f1',
            'url' => 'reports/products',
            
            'types' => [
                'summary' => [
                    'label' => 'Products Summary',
                    'description' => 'Top selling products',
                    'model' => 'Summary_items',
                    'filters' => ['date_range', 'location', 'sale_type', 'category'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'box'
                ],
                'categories' => [
                    'label' => 'Categories',
                    'description' => 'Sales by category',
                    'model' => 'Summary_categories',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['pie', 'bar'],
                    'default_chart' => 'pie',
                    'icon' => 'tags'
                ],
                'discounts' => [
                    'label' => 'Discounts',
                    'description' => 'Discount analysis',
                    'model' => 'Summary_discounts',
                    'filters' => ['date_range', 'location', 'sale_type', 'discount_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'tag'
                ],
                'inventory' => [
                    'label' => 'Inventory Summary',
                    'description' => 'Current stock levels',
                    'model' => 'Inventory_summary',
                    'filters' => ['location', 'category'],
                    'supports_chart' => false,
                    'icon' => 'clipboard-data'
                ],
                'low_stock' => [
                    'label' => 'Low Stock',
                    'description' => 'Items below reorder level',
                    'model' => 'Inventory_low',
                    'filters' => ['location'],
                    'supports_chart' => false,
                    'icon' => 'exclamation-triangle'
                ],
                'expiring' => [
                    'label' => 'Expiring Items',
                    'description' => 'Items near expiration',
                    'model' => 'Inventory_expiring',
                    'filters' => ['date_range', 'location'],
                    'supports_chart' => false,
                    'icon' => 'calendar-x'
                ]
            ]
        ],
        
        // ===== CUSTOMER REPORTS =====
        'customers' => [
            'title' => 'Customer Reports',
            'description' => 'Customer behavior and insights',
            'icon' => 'people-fill',
            'color' => '#3b82f6',
            'url' => 'reports/customers',
            
            'types' => [
                'summary' => [
                    'label' => 'Summary',
                    'description' => 'All customers summary',
                    'model' => 'Summary_customers',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'person-badge'
                ],
                'specific' => [
                    'label' => 'Specific Customer',
                    'description' => 'Detailed customer report',
                    'model' => 'Specific_customer',
                    'filters' => ['date_range', 'customer_id'],
                    'supports_chart' => false,
                    'icon' => 'person-check'
                ],
                'rewards' => [
                    'label' => 'Rewards',
                    'description' => 'Loyalty points summary',
                    'model' => 'Summary_rewards',
                    'filters' => ['date_range'],
                    'supports_chart' => true,
                    'chart_types' => ['bar'],
                    'default_chart' => 'bar',
                    'icon' => 'gift'
                ]
            ]
        ],
        
        // ===== SUPPLIER REPORTS =====
        'suppliers' => [
            'title' => 'Supplier Reports',
            'description' => 'Purchase and supplier analysis',
            'icon' => 'building',
            'color' => '#f59e0b',
            'url' => 'reports/suppliers',
            
            'types' => [
                'summary' => [
                    'label' => 'Summary',
                    'description' => 'All suppliers summary',
                    'model' => 'Summary_suppliers',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'shop'
                ],
                'specific' => [
                    'label' => 'Specific Supplier',
                    'description' => 'Detailed supplier report',
                    'model' => 'Specific_supplier',
                    'filters' => ['date_range', 'supplier_id'],
                    'supports_chart' => false,
                    'icon' => 'shop-window'
                ],
                'receivings' => [
                    'label' => 'Receivings',
                    'description' => 'Purchase history',
                    'model' => 'Detailed_receivings',
                    'filters' => ['date_range', 'location'],
                    'supports_chart' => false,
                    'icon' => 'truck'
                ]
            ]
        ],
        
        // ===== EMPLOYEE REPORTS =====
        'employees' => [
            'title' => 'Employee Reports',
            'description' => 'Staff performance tracking',
            'icon' => 'person-workspace',
            'color' => '#8b5cf6',
            'url' => 'reports/employees',
            
            'types' => [
                'summary' => [
                    'label' => 'Summary',
                    'description' => 'All employees summary',
                    'model' => 'Summary_employees',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'people'
                ],
                'specific' => [
                    'label' => 'Specific Employee',
                    'description' => 'Detailed employee report',
                    'model' => 'Specific_employee',
                    'filters' => ['date_range', 'employee_id'],
                    'supports_chart' => false,
                    'icon' => 'person'
                ],
                'timeclock' => [
                    'label' => 'Time Clock',
                    'description' => 'Hours worked report',
                    'model' => 'Timeclock',
                    'filters' => ['date_range', 'employee_id'],
                    'supports_chart' => false,
                    'icon' => 'clock'
                ]
            ]
        ],
        
        // ===== FINANCIAL REPORTS =====
        'financial' => [
            'title' => 'Financial Reports',
            'description' => 'Financial analysis and tracking',
            'icon' => 'cash-coin',
            'color' => '#ec4899',
            'url' => 'reports/financial',
            
            'types' => [
                'payments' => [
                    'label' => 'Payments',
                    'description' => 'Payment methods summary',
                    'model' => 'Summary_payments',
                    'filters' => ['date_range'],
                    'supports_chart' => true,
                    'chart_types' => ['pie', 'bar'],
                    'default_chart' => 'pie',
                    'icon' => 'credit-card'
                ],
                'taxes' => [
                    'label' => 'Taxes',
                    'description' => 'Tax summary',
                    'model' => 'Summary_taxes',
                    'filters' => ['date_range', 'location', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'percent'
                ],
                'discounts' => [
                    'label' => 'Discounts',
                    'description' => 'Discount impact analysis',
                    'model' => 'Summary_discounts',
                    'filters' => ['date_range', 'location', 'sale_type', 'discount_type'],
                    'supports_chart' => true,
                    'chart_types' => ['bar', 'pie'],
                    'default_chart' => 'bar',
                    'icon' => 'tag-fill'
                ],
                'expenses' => [
                    'label' => 'Expenses',
                    'description' => 'Expense categories breakdown',
                    'model' => 'Summary_expenses_categories',
                    'filters' => ['date_range', 'sale_type'],
                    'supports_chart' => true,
                    'chart_types' => ['pie', 'bar'],
                    'default_chart' => 'pie',
                    'icon' => 'wallet2'
                ]
            ]
        ]
    ];
    
    /**
     * Available filter types and their configurations
     */
    public array $filters = [
        'date_range' => [
            'label' => 'Date Range',
            'type' => 'daterange',
            'required' => true,
            'default' => 'this_month'
        ],
        'location' => [
            'label' => 'Location',
            'type' => 'select',
            'source' => 'stock_locations',
            'required' => false,
            'default' => 'all'
        ],
        'sale_type' => [
            'label' => 'Sale Type',
            'type' => 'select',
            'options' => [
                'all' => 'All',
                'sales' => 'Sales Only',
                'returns' => 'Returns Only'
            ],
            'required' => false,
            'default' => 'all'
        ],
        'category' => [
            'label' => 'Category',
            'type' => 'select',
            'source' => 'categories',
            'required' => false,
            'default' => 'all'
        ],
        'discount_type' => [
            'label' => 'Discount Type',
            'type' => 'select',
            'options' => [
                '0' => 'All Types',
                '1' => 'Percentage',
                '2' => 'Fixed Amount'
            ],
            'required' => false,
            'default' => '0'
        ],
        'customer_id' => [
            'label' => 'Customer',
            'type' => 'autocomplete',
            'source' => 'customers',
            'required' => true
        ],
        'supplier_id' => [
            'label' => 'Supplier',
            'type' => 'autocomplete',
            'source' => 'suppliers',
            'required' => true
        ],
        'employee_id' => [
            'label' => 'Employee',
            'type' => 'autocomplete',
            'source' => 'employees',
            'required' => true
        ]
    ];
}
