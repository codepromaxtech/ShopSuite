<?php
/**
 * Module Helper Functions
 */

if (!function_exists('getModuleIcon')) {
    /**
     * Get Bootstrap icon class for a module
     */
    function getModuleIcon(string $module_id): string
    {
        $icons = [
            'home' => 'bi-house-fill',
            'customers' => 'bi-people-fill',
            'items' => 'bi-box-seam-fill',
            'sales' => 'bi-cart-fill',
            'suppliers' => 'bi-truck',
            'receivings' => 'bi-arrow-down-circle-fill',
            'reports' => 'bi-graph-up',
            'employees' => 'bi-person-badge-fill',
            'giftcards' => 'bi-gift-fill',
            'expenses' => 'bi-cash-stack',
            'cashups' => 'bi-calculator-fill',
            'config' => 'bi-gear-fill',
            'roles' => 'bi-shield-lock-fill',
            'backups' => 'bi-database-fill-down',
            'taxes' => 'bi-percent',
            'attributes' => 'bi-tags-fill',
            'expenses_categories' => 'bi-folder-fill',
            'messages' => 'bi-chat-dots-fill',
            'item_kits' => 'bi-boxes',
            'office' => 'bi-building',
            'migrate' => 'bi-arrow-repeat'
        ];

        return $icons[$module_id] ?? 'bi-app';
    }
}
