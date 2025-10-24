<?php
/**
 * MODERN OFFICE DASHBOARD - Bootstrap 5
 * Main module selector page
 * @var array $allowed_modules
 * @var array $user_info
 * @var array $config
 */
?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($config['company']) ?> - <?= lang('Common.welcome_message') ?></title>
    
    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #ecf0f1;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .welcome-section {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }
        
        .welcome-section h1 {
            font-size: 2.5rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            margin-bottom: 0.5rem;
        }
        
        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 0 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .module-card {
            background: white;
            border-radius: 15px;
            padding: 2rem 1rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .module-card:hover::before {
            transform: scaleX(1);
        }
        
        .module-icon {
            width: 64px;
            height: 64px;
            transition: transform 0.3s ease;
        }
        
        .module-card:hover .module-icon {
            transform: scale(1.1);
        }
        
        .module-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }
        
        .module-desc {
            font-size: 0.85rem;
            color: #7f8c8d;
            margin: 0;
            line-height: 1.4;
        }
        
        .user-info-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }
        
        .user-info-card i {
            font-size: 1.5rem;
        }
        
        .module-search-container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .module-search-container .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
            border-color: white;
        }
        
        .module-card.hidden {
            display: none;
        }
        
        .no-results {
            text-align: center;
            color: white;
            padding: 2rem;
            font-size: 1.1rem;
            display: none;
        }
        
        .no-results.show {
            display: block;
        }
        
        @media (max-width: 768px) {
            .modules-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
            
            .welcome-section h1 {
                font-size: 2rem;
            }
            
            .module-card {
                padding: 1.5rem 0.5rem;
            }
            
            .module-search-container {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold"><?= esc($config['company']) ?></h5>
                    <small class="text-muted">Point of Sale System</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">
                        <i class="bi bi-person-circle"></i>
                        <?= esc($user_info->first_name . ' ' . $user_info->last_name) ?>
                    </span>
                    <a href="<?= base_url('home/logout') ?>" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="container">
            <h1><?= lang('Common.welcome_message') ?></h1>
            <p>Select a module to get started</p>
            
            <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap mb-3">
                <div class="user-info-card">
                    <i class="bi bi-calendar-check"></i>
                    <span><?= date('l, F d, Y') ?></span>
                </div>
                <div class="user-info-card">
                    <i class="bi bi-clock"></i>
                    <span id="current-time"><?= date('h:i A') ?></span>
                </div>
            </div>
            
            <!-- Module Search -->
            <div class="module-search-container">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0" 
                           id="moduleSearch" 
                           placeholder="Search modules..." 
                           style="background: white; border-left: none;">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modules Grid -->
    <div class="container mb-5">
        <div class="no-results">
            <i class="bi bi-search" style="font-size: 3rem; opacity: 0.5;"></i>
            <p class="mt-3">No modules found matching your search</p>
        </div>
        <div class="modules-grid">
            <?php foreach ($allowed_modules as $module): ?>
                <a href="<?= base_url($module->module_id) ?>" 
                   class="module-card" 
                   data-module-name="<?= esc(strtolower(lang("Module.$module->module_id"))) ?>"
                   data-module-desc="<?= esc(strtolower(lang("Module.$module->module_id" . '_desc'))) ?>">
                    <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" 
                         alt="<?= lang("Module.$module->module_id") ?>" 
                         class="module-icon">
                    <div>
                        <h6 class="module-name"><?= lang("Module.$module->module_id") ?></h6>
                        <p class="module-desc"><?= lang("Module.$module->module_id" . '_desc') ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="text-center text-white pb-4">
        <small class="opacity-75">
            Powered by ShopSuite &copy; <?= date('Y') ?>
        </small>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            document.getElementById('current-time').textContent = timeStr;
        }
        setInterval(updateTime, 1000);
        
        // Module search functionality
        const searchInput = document.getElementById('moduleSearch');
        const moduleCards = document.querySelectorAll('.module-card');
        const noResults = document.querySelector('.no-results');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;
            
            moduleCards.forEach(card => {
                const moduleName = card.getAttribute('data-module-name');
                const moduleDesc = card.getAttribute('data-module-desc');
                const matches = moduleName.includes(searchTerm) || moduleDesc.includes(searchTerm);
                
                if (matches || searchTerm === '') {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });
            
            // Show/hide no results message
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.classList.add('show');
            } else {
                noResults.classList.remove('show');
            }
        });
        
        // Add keyboard shortcut (Ctrl+K or Cmd+K to focus search)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
            
            // ESC to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        });
        
        console.log('✨ Modern Office Dashboard Loaded');
        console.log('💡 Tip: Press Ctrl+K to search modules');
    </script>
</body>
</html>
