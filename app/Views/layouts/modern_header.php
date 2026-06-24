<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#0ea5e9">
    <title><?= esc($title ?? 'ShopSuite - Modern ERP System') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Design System CSS -->
    <link rel="stylesheet" href="<?= base_url('css/design-system.min.css') ?>?v=<?= filemtime(FCPATH . 'css/design-system.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/components.min.css') ?>?v=<?= filemtime(FCPATH . 'css/components.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/layout.min.css') ?>?v=<?= filemtime(FCPATH . 'css/layout.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modern-pages.min.css') ?>?v=<?= filemtime(FCPATH . 'css/modern-pages.min.css') ?>">
    
    <!-- Additional Page-Specific CSS -->
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= base_url($css) ?>?v=<?= filemtime(FCPATH . $css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Core JavaScript (loaded in head for ModernDataTable) -->
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script src="<?= base_url('js/modern-datatable.js') ?>"></script>
</head>
<body>
    <!-- App Shell -->
    <div class="app-shell">
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <img src="<?= base_url('images/logo.png') ?>" alt="ShopSuite" class="sidebar-logo-img" onerror="this.style.display='none'">
                <span class="sidebar-logo-text">ShopSuite</span>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                <!-- Main Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Main</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('home') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="sidebar-menu-text">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Sales Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Sales</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('sales') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Sales</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('customers') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Customers</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('giftcards') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                                <span class="sidebar-menu-text">Gift Cards</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Inventory Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Inventory</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('products') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="sidebar-menu-text">Products</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('product_bundles') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="sidebar-menu-text">Product Bundles</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('receivings') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span class="sidebar-menu-text">Receivings</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('suppliers') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="sidebar-menu-text">Suppliers</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Finance Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Finance</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('expenses') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Expenses</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('cashups') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Cash Ups</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('taxes') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Taxes</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Reports Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Reports</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('reports') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Reports</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- System Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">System</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('employees') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Employees</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('roles') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Roles</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('config') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="sidebar-menu-text">Settings</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="<?= base_url('backups') ?>" class="sidebar-menu-link">
                                <svg class="sidebar-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                <span class="sidebar-menu-text">Backups</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="app-content">
            <!-- Header -->
            <header class="app-header">
                <div class="header-left">
                    <button class="header-toggle" data-action="toggle-sidebar" aria-label="Toggle Sidebar">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="header-search mobile:hidden">
                        <svg class="header-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" class="header-search-input" placeholder="Search..." id="globalSearch">
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Theme Toggle -->
                    <button class="header-action" data-action="toggle-theme" title="Toggle Dark/Light Mode">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    
                    <!-- Input Mode Toggle -->
                    <button class="header-action" data-action="toggle-input-mode" title="Toggle Touch/Regular Mode">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    
                    <!-- Notifications -->
                    <button class="header-action" data-dropdown-toggle="notificationsDropdown">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="header-action-badge">3</span>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="header-user" data-dropdown-toggle="userDropdown">
                            <div class="avatar avatar-md">
                                <?php 
                                $username = session()->get('username') ?? 'Admin';
                                echo strtoupper(substr($username, 0, 2));
                                ?>
                            </div>
                            <div class="header-user-info">
                                <span class="header-user-name"><?= esc($username) ?></span>
                                <span class="header-user-role">Administrator</span>
                            </div>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-right d-none" id="userDropdown">
                            <a href="<?= base_url('employees/view/' . (session()->get('person_id') ?? '1')) ?>" class="dropdown-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </a>
                            <a href="<?= base_url('config') ?>" class="dropdown-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('home/logout') ?>" class="dropdown-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="content-wrapper">
