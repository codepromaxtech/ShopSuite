<?php
/**
 * Modern Bootstrap 5 Header Layout for ShopSuite
 * Clean, minimal, and professional design
 */

use Config\Services;

$request = Services::request();
$config = config('ShopSuite')->settings ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ShopSuite - Modern Point of Sale System">
    <title><?= esc($config['company'] ?? 'ShopSuite') ?> | <?= $page_title ?? 'Dashboard' ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 (Latest) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap Table CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css">
    
    <!-- SweetAlert2 CSS (Bootstrap 5 compatible) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- File Upload CSS -->
    <link rel="stylesheet" href="<?= base_url('css/file-upload.css') ?>">
    
    <!-- Load CSS from gulp bundles -->
    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getUri()->getQuery()): ?>
        <!-- inject:debug:css -->
        <!-- endinject -->
    <?php else: ?>
        <!-- inject:prod:css -->
        <!-- endinject -->
    <?php endif; ?>
    
    <!-- jQuery 3.x (Latest) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    
    <!-- Bootstrap 5.3.3 JS (Latest) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS (Modern alerts) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Bootstrap Table (Latest) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
    
    <!-- jQuery Validation (for forms) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    
    <!-- jQuery Form Plugin (for AJAX forms) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-form@4.3.0/dist/jquery.form.min.js"></script>
    
    <!-- Modern Features (Dark Mode, Animations, Export, etc.) -->
    <script src="<?= base_url('js/modern-features.js') ?>"></script>
    
    <!-- File Upload with Drag & Drop -->
    
    <!-- Modern Table System (NEW) -->
    <script src="<?= base_url('js/modern-table.js') ?>"></script>
    
    <!-- Modern DataTable (Pure Native Solution) -->
    <script src="<?= base_url('js/modern-datatable.js') ?>"></script>
    
    <!-- Modern Modal System (NEW - replaces BootstrapDialog) -->
    <script src="<?= base_url('js/modern-modal.js') ?>"></script>

<!-- Global Configuration -->
<script>
// Base URL for AJAX calls
const BASE_URL = '<?= base_url() ?>';

// Loading indicator
function showLoading(message = 'Loading...') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
}

function hideLoading() {
    if (typeof Swal !== 'undefined') {
        Swal.close();
    }
}

// Notification helper
function showNotification(message, type = 'info') {
    if (typeof Swal !== 'undefined') {
        const iconMap = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info'
        };
        
        Swal.fire({
            icon: iconMap[type] || 'info',
            title: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        console.log(`[${type.toUpperCase()}] ${message}`);
    }
}
</script>
    
    
    <!-- Lang Lines (no dependencies) -->
    <?= view('partial/lang_lines') ?>
    <!-- Header JS (depends on jQuery, Moment, etc - load last) -->
    <?= view('partial/header_js') ?>
    
    <!-- Custom CSS - Modern Enhanced -->
    <style>
        :root {
            /* Brand Colors */
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --sidebar-width: 260px;
            
            /* Light Mode (Default) */
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #f3f4f6;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            
            /* Animation Variables */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Dark Mode */
        [data-bs-theme="dark"] {
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --bg-tertiary: #0f172a;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --border-color: #374151;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.6);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-section {
            margin: 1.5rem 0 0.5rem 0;
        }
        
        .menu-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 0.5rem;
        }
        
        .menu-item {
            margin: 0.25rem 0.75rem;
        }
        
        .menu-collapse {
            cursor: pointer;
            position: relative;
        }
        
        .menu-collapse::after {
            content: '\f282';
            font-family: 'bootstrap-icons';
            position: absolute;
            right: 1rem;
            transition: transform 0.3s ease;
        }
        
        .menu-collapse.collapsed::after {
            transform: rotate(-90deg);
        }
        
        .submenu {
            padding-left: 1rem;
            max-height: 500px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .submenu.collapse:not(.show) {
            max-height: 0;
        }
        
        .submenu .menu-link {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            font-size: 0.9rem;
        }
        
        .submenu-group {
            margin-top: 0.75rem;
        }
        
        .submenu-group-title {
            padding: 0.5rem 1rem 0.25rem 2.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255,255,255,0.4);
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .menu-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .menu-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }
        
        .menu-link i {
            font-size: 1.25rem;
            width: 30px;
            margin-right: 0.75rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .navbar-actions .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .user-dropdown:hover {
            background: var(--light-color);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        /* Content Area */
        .content-area {
            padding: 2rem;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Modern Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .fade-in {
            animation: fadeIn var(--transition-base) ease-in;
        }
        
        .slide-up {
            animation: slideUp var(--transition-base) ease-out;
        }
        
        .slide-down {
            animation: slideDown var(--transition-base) ease-out;
        }
        
        /* Loading States */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 2000px 100%;
            animation: shimmer 2s infinite linear;
            border-radius: 4px;
        }
        
        [data-bs-theme="dark"] .skeleton {
            background: linear-gradient(90deg, #2d2d2d 25%, #3d3d3d 50%, #2d2d2d 75%);
            background-size: 2000px 100%;
        }
        
        .skeleton-text {
            height: 16px;
            margin-bottom: 8px;
        }
        
        .skeleton-title {
            height: 24px;
            width: 60%;
            margin-bottom: 16px;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15rem;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Enhanced Table Styles */
        .table {
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: var(--transition-base);
        }
        
        .table-hover tbody tr:hover {
            background-color: var(--bg-tertiary);
            transform: scale(1.001);
            box-shadow: var(--shadow-sm);
        }
        
        .table thead th {
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        /* Enhanced Buttons */
        .btn-group .btn:hover {
            z-index: 2;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #2563eb);
        }
        
        /* Export Buttons */
        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all var(--transition-base);
        }
        
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-export i {
            font-size: 1.125rem;
        }
        
        
        /* Notification Badge */
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            background: var(--danger-color);
            color: white;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Progress Bar Enhanced */
        .progress {
            height: 0.5rem;
            border-radius: 1rem;
            overflow: hidden;
            background: var(--bg-tertiary);
        }
        
        .progress-bar {
            transition: width 0.6s ease;
        }
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shop"></i> ShopSuite</h4>
        </div>
        
        <div class="sidebar-menu">
            <?php 
            // Categorize modules
            $main_modules = ['home', 'sales', 'items', 'customers', 'suppliers', 'receivings', 'reports'];
            
            // Settings grouped by category
            $settings_groups = [
                'system' => ['config', 'roles', 'employees', 'backups'],
                'business' => ['taxes', 'attributes', 'giftcards', 'item_kits'],
                'financial' => ['expenses', 'expenses_categories', 'cashups'],
                'tools' => ['messages', 'migrate']
            ];
            
            // Flatten settings for categorization
            $all_settings = [];
            foreach ($settings_groups as $group => $modules) {
                $all_settings = array_merge($all_settings, $modules);
            }
            
            $categorized = [
                'main' => [],
                'settings' => [
                    'system' => [],
                    'business' => [],
                    'financial' => [],
                    'tools' => []
                ],
                'other' => []
            ];
            
            if (isset($allowed_modules) && is_array($allowed_modules)) {
                foreach ($allowed_modules as $module) {
                    // Skip office module
                    if ($module->module_id === 'office') {
                        continue;
                    }
                    
                    if (in_array($module->module_id, $main_modules)) {
                        $categorized['main'][] = $module;
                    } elseif (in_array($module->module_id, $all_settings)) {
                        // Find which group this module belongs to
                        foreach ($settings_groups as $group => $group_modules) {
                            if (in_array($module->module_id, $group_modules)) {
                                $categorized['settings'][$group][] = $module;
                                break;
                            }
                        }
                    } else {
                        $categorized['other'][] = $module;
                    }
                }
            }
            
            $current_module = $request->getUri()->getSegment(1);
            
            // Check if we're on a settings page to auto-expand
            $is_settings_active = in_array($current_module, $all_settings);
            ?>
            
            <!-- Main Modules -->
            <?php if (!empty($categorized['main'])): ?>
                <div class="menu-section">
                    <div class="menu-section-title">Main Menu</div>
                    <?php foreach ($categorized['main'] as $module): ?>
                        <div class="menu-item">
                            <a href="<?= base_url($module->module_id) ?>" 
                               class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                <span><?= lang('Module.' . $module->module_id) ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Settings Section (Collapsible) -->
            <?php 
            $has_settings = false;
            foreach ($categorized['settings'] as $group => $modules) {
                if (!empty($modules)) {
                    $has_settings = true;
                    break;
                }
            }
            ?>
            <?php if ($has_settings): ?>
                <div class="menu-section">
                    <div class="menu-item">
                        <a class="menu-link menu-collapse <?= !$is_settings_active ? 'collapsed' : '' ?>" 
                           data-bs-toggle="collapse" 
                           href="#settingsMenu" 
                           role="button" 
                           aria-expanded="<?= $is_settings_active ? 'true' : 'false' ?>">
                            <i class="bi bi-gear-fill"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                    <div class="collapse submenu <?= $is_settings_active ? 'show' : '' ?>" id="settingsMenu">
                        
                        <!-- System Settings -->
                        <?php if (!empty($categorized['settings']['system'])): ?>
                            <div class="submenu-group">
                                <div class="submenu-group-title">System</div>
                                <?php foreach ($categorized['settings']['system'] as $module): ?>
                                    <div class="menu-item">
                                        <a href="<?= base_url($module->module_id) ?>" 
                                           class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                            <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                            <span><?= lang('Module.' . $module->module_id) ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Business Settings -->
                        <?php if (!empty($categorized['settings']['business'])): ?>
                            <div class="submenu-group">
                                <div class="submenu-group-title">Business</div>
                                <?php foreach ($categorized['settings']['business'] as $module): ?>
                                    <div class="menu-item">
                                        <a href="<?= base_url($module->module_id) ?>" 
                                           class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                            <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                            <span><?= lang('Module.' . $module->module_id) ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Financial Settings -->
                        <?php if (!empty($categorized['settings']['financial'])): ?>
                            <div class="submenu-group">
                                <div class="submenu-group-title">Financial</div>
                                <?php foreach ($categorized['settings']['financial'] as $module): ?>
                                    <div class="menu-item">
                                        <a href="<?= base_url($module->module_id) ?>" 
                                           class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                            <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                            <span><?= lang('Module.' . $module->module_id) ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Tools -->
                        <?php if (!empty($categorized['settings']['tools'])): ?>
                            <div class="submenu-group">
                                <div class="submenu-group-title">Tools</div>
                                <?php foreach ($categorized['settings']['tools'] as $module): ?>
                                    <div class="menu-item">
                                        <a href="<?= base_url($module->module_id) ?>" 
                                           class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                            <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                            <span><?= lang('Module.' . $module->module_id) ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Other Modules -->
            <?php if (!empty($categorized['other'])): ?>
                <div class="menu-section">
                    <div class="menu-section-title">Other</div>
                    <?php foreach ($categorized['other'] as $module): ?>
                        <div class="menu-item">
                            <a href="<?= base_url($module->module_id) ?>" 
                               class="menu-link <?= ($current_module == $module->module_id) ? 'active' : '' ?>">
                                <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                                <span><?= lang('Module.' . $module->module_id) ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="navbar-content">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-toggle" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h1 class="page-title mb-0"><?= $page_title ?? 'Dashboard' ?></h1>
                        <small class="text-muted d-none d-lg-block"><?= esc($config['company'] ?? 'ShopSuite') ?></small>
                    </div>
                </div>
                
                <div class="navbar-actions">
                    <!-- Live Clock -->
                    <div id="liveclock" class="text-muted d-none d-md-block fw-medium" style="font-size: 0.875rem;">
                        <i class="bi bi-clock me-1"></i>
                        <span id="clock-time">Loading...</span>
                    </div>
                    
                    <button class="btn btn-light" title="Notifications">
                        <i class="bi bi-bell"></i>
                    </button>
                    
                    <div class="dropdown">
                        <div class="user-dropdown" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= strtoupper(substr($user_info->first_name ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="d-none d-md-block">
                                <div class="fw-semibold"><?= esc($user_info->first_name ?? 'User') ?> <?= esc($user_info->last_name ?? '') ?></div>
                                <small class="text-muted"><?= esc($user_info->username ?? '') ?></small>
                            </div>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 250px;">
                            <!-- User Info Header -->
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-semibold"><?= esc($user_info->first_name ?? 'User') ?> <?= esc($user_info->last_name ?? '') ?></div>
                                <small class="text-muted"><?= esc($user_info->email ?? $user_info->username ?? '') ?></small>
                            </li>
                            
                            <!-- Profile & Settings -->
                            <li><a class="dropdown-item" href="<?= base_url('home/user_settings') ?>">
                                <i class="bi bi-person-gear me-2"></i> My Settings
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('employees/view/' . ($user_info->person_id ?? '')) ?>">
                                <i class="bi bi-person-circle me-2"></i> My Profile
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('config') ?>">
                                <i class="bi bi-gear me-2"></i> System Settings
                            </a></li>
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <!-- Logout -->
                            <li><a class="dropdown-item text-danger" href="<?= base_url('home/logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Content Area -->
        <div class="content-area">
