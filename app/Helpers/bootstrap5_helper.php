<?php
/**
 * Bootstrap 5 Helper Functions for ShopSuite
 */

if (!function_exists('getModuleIcon')) {
    /**
     * Get icon class for a module
     * 
     * @param string $module_id
     * @return string
     */
    function getModuleIcon($module_id) {
        $icons = [
            'home' => 'bi bi-house-door',
            'sales' => 'bi bi-cart',
            'items' => 'bi bi-box-seam',
            'customers' => 'bi bi-people',
            'suppliers' => 'bi bi-truck',
            'reports' => 'bi bi-graph-up',
            'employees' => 'bi bi-person-badge',
            'giftcards' => 'bi bi-gift',
            'config' => 'bi bi-gear',
            'receivings' => 'bi bi-box-arrow-in-down',
            'item_kits' => 'bi bi-boxes',
            'expenses' => 'bi bi-cash-coin',
            'cashups' => 'bi bi-cash-stack',
            'taxes' => 'bi bi-percent',
            'roles' => 'bi bi-shield-lock',
        ];
        
        return $icons[$module_id] ?? 'bi bi-circle';
    }
}

if (!function_exists('getModuleColor')) {
    /**
     * Get color class for a module
     * 
     * @param string $module_id
     * @return string
     */
    function getModuleColor($module_id) {
        $colors = [
            'home' => 'primary',
            'sales' => 'success',
            'items' => 'info',
            'customers' => 'warning',
            'suppliers' => 'secondary',
            'reports' => 'danger',
            'employees' => 'indigo',
            'giftcards' => 'pink',
            'config' => 'dark',
            'receivings' => 'teal',
            'item_kits' => 'cyan',
            'expenses' => 'orange',
            'cashups' => 'lime',
            'taxes' => 'purple',
            'roles' => 'indigo',
        ];
        
        return $colors[$module_id] ?? 'primary';
    }
}

if (!function_exists('getModuleGradient')) {
    /**
     * Get gradient colors for a module
     * 
     * @param string $module_id
     * @return string
     */
    function getModuleGradient($module_id) {
        $gradients = [
            'home' => '#667eea, #764ba2',
            'sales' => '#10b981, #059669',
            'items' => '#3b82f6, #2563eb',
            'customers' => '#f59e0b, #d97706',
            'suppliers' => '#6366f1, #4f46e5',
            'reports' => '#ef4444, #dc2626',
            'employees' => '#8b5cf6, #7c3aed',
            'giftcards' => '#ec4899, #db2777',
            'config' => '#1f2937, #111827',
            'receivings' => '#14b8a6, #0d9488',
            'item_kits' => '#06b6d4, #0891b2',
            'expenses' => '#f97316, #ea580c',
            'cashups' => '#84cc16, #65a30d',
            'taxes' => '#a855f7, #9333ea',
        ];
        
        return $gradients[$module_id] ?? '#667eea, #764ba2';
    }
}
