<?php
/**
 * MODERN OFFICE DASHBOARD - Bootstrap 5
 * Main module selector page
 * @var array $allowed_modules
 * @var array $user_info
 * @var array $config
 */
?>

$title = 'Dashboard';
echo view('layouts/modern_header', ['title' => $title]);
?>
<!-- Welcome Banner -->
<div class="welcome-banner mb-4 p-4 rounded-3 bg-secondary" >
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2"><i class="bi bi-house-door me-2"></i><?= lang('Common.welcome_message') ?></h2>
            <p class="mb-0 opacity-90">Choose a module below to get started</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex justify-content-md-end gap-2 flex-wrap mt-3 mt-md-0">
                <div class="badge badge-secondary px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar3 me-1"></i>
                    <?= date('M d, Y') ?>
                </div>
                <div class="badge badge-secondary px-3 py-2 rounded-pill">
                    <i class="bi bi-clock me-1"></i>
                    <span id="dashboard-time"><?= date('h:i A') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Module Search -->
<div class="mb-4">
    <div class="input-group input-group-lg">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" 
               class="form-control" 
               id="moduleSearch" 
               placeholder="Search modules by name or description...">
        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <small class="text-secondary ms-2"><i class="bi bi-info-circle me-1"></i>Tip: Press Ctrl+K to focus search</small>
</div>

<!-- Modules Grid -->
<div class="row g-4" id="modulesGrid">
    <?php foreach ($allowed_modules as $module): ?>
        <div class="col-xl-3 col-lg-4 col-md-6 module-col" 
             data-module-name="<?= esc(strtolower(lang("Module.$module->module_id"))) ?>"
             data-module-desc="<?= esc(strtolower(lang("Module.$module->module_id" . '_desc'))) ?>">
            <a href="<?= base_url($module->module_id) ?>" class="text-decoration-none">
                <div class="card h-100 module-card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="module-icon-wrapper mb-3">
                            <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" 
                                 alt="<?= lang("Module.$module->module_id") ?>" 
                                 class="module-icon"
                                 style="width: 64px; height: 64px;">
                        </div>
                        <h5 class="card-title mb-2 fw-bold"><?= lang("Module.$module->module_id") ?></h5>
                        <p class="card-text text-secondary small mb-0">
                            <?= lang("Module.$module->module_id" . '_desc') ?>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 text-center">
                        <small class="text-primary">
                            <i class="bi bi-arrow-right-circle me-1"></i>Open Module
                        </small>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<!-- No Results Message -->
<div id="noResults" class="text-center py-5 d-none">
    <i class="bi bi-search text-secondary u-font-size-4rem_opacity-03"></i>
    <h4 class="mt-3 text-secondary">No modules found</h4>
    <p class="text-secondary">Try a different search term</p>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✨ Modern Office Dashboard Loaded');
    
    // Update time every second
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        const timeEl = document.getElementById('dashboard-time');
        if (timeEl) timeEl.textContent = timeStr;
    }
    setInterval(updateTime, 1000);
    
    // Module search functionality
    const searchInput = document.getElementById('moduleSearch');
    const moduleCols = document.querySelectorAll('.module-col');
    const noResults = document.getElementById('noResults');
    const clearBtn = document.getElementById('clearSearch');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        moduleCols.forEach(col => {
            const moduleName = col.getAttribute('data-module-name');
            const moduleDesc = col.getAttribute('data-module-desc');
            const matches = moduleName.includes(searchTerm) || moduleDesc.includes(searchTerm);
            
            if (matches || searchTerm === '') {
                col.classList.remove('hidden');
                visibleCount++;
            } else {
                col.classList.add('hidden');
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0 && searchTerm !== '') {
            noResults.style.display = 'block';
            document.getElementById('modulesGrid').style.display = 'none';
        } else {
            noResults.style.display = 'none';
            document.getElementById('modulesGrid').style.display = 'flex';
        }
    }
    
    searchInput.addEventListener('input', performSearch);
    
    // Clear search
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        performSearch();
        searchInput.focus();
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        
        // ESC to clear search
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.value = '';
            performSearch();
            searchInput.blur();
        }
    });
    
    console.log('💡 Tip: Press Ctrl+K to search modules');
});
</script>

<?= view('layouts/modern_footer') ?>
