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
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- SweetAlert2 CSS (Bootstrap 5 compatible) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Load CSS from gulp bundles -->
    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getUri()->getQuery()): ?>
        <!-- inject:debug:css -->
        <!-- endinject -->
    <?php else: ?>
        <!-- inject:prod:css -->
        <!-- endinject -->
    <?php endif; ?>
    
    <!-- Load jQuery and plugins from gulp-generated bundles FIRST -->
    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getUri()->getQuery()): ?>
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else: ?>
        <!-- inject:prod:js -->
        <script src="resources/jquery-2c872dbe60.min.js"></script>
        <script src="resources/shopsuite-a71baa0f6b.min.js"></script>
        <!-- endinject -->
    <?php endif; ?>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS (Bootstrap 5 compatible) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- BootstrapDialog compatibility shim for Bootstrap 5 -->
    <script>
    // Create BootstrapDialog wrapper using Bootstrap 5 modals
    window.BootstrapDialog = {
        TYPE_DEFAULT: 'default',
        TYPE_INFO: 'info',
        TYPE_PRIMARY: 'primary',
        TYPE_SUCCESS: 'success',
        TYPE_WARNING: 'warning',
        TYPE_DANGER: 'danger',
        
        show: function(options) {
            var modalId = 'modal-' + Date.now();
            var title = options.title || '';
            var message = options.message || '';
            var buttons = options.buttons || [];
            var cssClass = options.cssClass || 'modal-lg';
            
            // Handle dialog size from cssClass
            var dialogSize = 'modal-lg';
            if (cssClass.includes('modal-dlg-wide')) dialogSize = 'modal-xl';
            else if (cssClass.includes('modal-dlg-small')) dialogSize = 'modal-sm';
            
            // Create modal HTML
            var modalHtml = '<div class="modal fade" id="' + modalId + '" tabindex="-1">' +
                '<div class="modal-dialog ' + dialogSize + '">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h5 class="modal-title">' + title + '</h5>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal"></button>' +
                '</div>' +
                '<div class="modal-body"></div>' +
                '<div class="modal-footer">';
            
            // Add buttons
            buttons.forEach(function(btn) {
                var btnClass = 'btn btn-' + (btn.cssClass || 'secondary');
                modalHtml += '<button type="button" id="' + btn.id + '" class="' + btnClass + '" data-action="' + (btn.id || '') + '">' + btn.label + '</button>';
            });
            
            modalHtml += '</div></div></div></div>';
            
            // Append to body
            $('body').append(modalHtml);
            
            // Get modal elements
            var $modalEl = $('#' + modalId);
            var modalEl = $modalEl[0];
            var $modalBody = $modalEl.find('.modal-body');
            var modal = new bootstrap.Modal(modalEl);
            
            // Set message content (can be jQuery object or string)
            if (typeof message === 'object' && message.jquery) {
                $modalBody.append(message);
            } else {
                $modalBody.html(message);
            }
            
            // Create dialog reference object
            var dialogRef = {
                $modal: $modalEl,
                $modalBody: $modalBody,
                $modalHeader: $modalEl.find('.modal-header'),
                $modalFooter: $modalEl.find('.modal-footer'),
                open: function() { modal.show(); },
                close: function() { modal.hide(); }
            };
            
            // Attach button handlers
            $modalEl.find('[data-action]').on('click', function(e) {
                var action = $(this).data('action');
                var button = buttons.find(function(b) { return b.id === action; });
                if (button && button.action) {
                    var result = button.action(dialogRef);
                    // Don't close if action returns false
                    if (result === false) {
                        e.preventDefault();
                        return false;
                    }
                }
                modal.hide();
            });
            
            // Attach hotkey handlers (Enter key)
            $modalEl.on('keydown', function(e) {
                if (e.which === 13) { // Enter key
                    var hotkeyBtn = buttons.find(function(b) { return b.hotkey === 13; });
                    if (hotkeyBtn) {
                        e.preventDefault();
                        $('#' + hotkeyBtn.id).click();
                    }
                }
            });
            
            // Show modal
            modal.show();
            
            // Remove modal from DOM after hiding
            $modalEl.on('hidden.bs.modal', function() {
                $(this).remove();
            });
            
            return dialogRef;
        }
    };
    </script>
    
    
    <!-- Lang Lines (no dependencies) -->
    <?= view('partial/lang_lines') ?>
    
    <!-- Header JS (depends on jQuery, Moment, etc - load last) -->
    <?= view('partial/header_js') ?>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --sidebar-width: 260px;
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
        
        .menu-item {
            margin: 0.25rem 0.75rem;
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
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shop"></i> ShopSuite</h4>
        </div>
        
        <div class="sidebar-menu">
            <?php if (isset($allowed_modules) && is_array($allowed_modules)): ?>
                <?php foreach ($allowed_modules as $module): ?>
                    <div class="menu-item">
                        <a href="<?= base_url($module->module_id) ?>" 
                           class="menu-link <?= ($request->getUri()->getSegment(1) == $module->module_id) ? 'active' : '' ?>">
                            <i class="<?= getModuleIcon($module->module_id) ?>"></i>
                            <span><?= lang('Module.' . $module->module_id) ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
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
                    <h1 class="page-title"><?= $page_title ?? 'Dashboard' ?></h1>
                </div>
                
                <div class="navbar-actions">
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
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('home/change_password/' . ($user_info->person_id ?? '')) ?>">
                                <i class="bi bi-key me-2"></i> Change Password
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
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
