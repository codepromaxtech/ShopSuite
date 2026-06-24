<?php
/**
 * Dynamic Filters Component
 * Renders filters based on report type configuration
 */
$typeConfig = $type_config;
$filterConfigs = $filter_configs;
$requiredFilters = $typeConfig['filters'] ?? [];
?>

<div class="filters-container">
    <?php foreach ($requiredFilters as $filterKey): ?>
        <?php 
        $filterConfig = $filterConfigs[$filterKey] ?? null;
        if (!$filterConfig) continue;
        ?>
        
        <div class="form-group filter-group" data-filter="<?= $filterKey ?>">
            <label for="filter_<?= $filterKey ?>" class="form-label">
                <i class="bi bi-funnel"></i>
                <?= $filterConfig['label'] ?>
                <?php if ($filterConfig['required'] ?? false): ?>
                    <span class="u-color-danger-600">*</span>
                <?php endif; ?>
            </label>
            
            <?php if ($filterKey === 'date_range'): ?>
                <!-- Date Range Filter -->
                <div class="date-range-inputs">
                    <div>
                        <label class="u-font-size-text-xs_color-text-tertiary">From</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            class="form-control"
                            value="<?= esc($_POST['start_date'] ?? date('Y-m-01')) ?>"
                            <?= ($filterConfig['required'] ?? false) ? 'required' : '' ?>
                        >
                    </div>
                    <div>
                        <label class="u-font-size-text-xs_color-text-tertiary">To</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            class="form-control"
                            value="<?= esc($_POST['end_date'] ?? date('Y-m-d')) ?>"
                            <?= ($filterConfig['required'] ?? false) ? 'required' : '' ?>
                        >
                    </div>
                </div>
                <div class="date-shortcuts">
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('today')">Today</button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('week')">This Week</button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('month')">This Month</button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('year')">This Year</button>
                </div>
                
            <?php elseif ($filterConfig['type'] === 'select'): ?>
                <!-- Select Filter -->
                <select 
                    name="<?= $filterKey ?>" 
                    id="filter_<?= $filterKey ?>" 
                    class="form-control"
                    <?= ($filterConfig['required'] ?? false) ? 'required' : '' ?>
                >
                    <?php if (isset($filterConfig['options'])): ?>
                        <!-- Static Options -->
                        <?php foreach ($filterConfig['options'] as $value => $label): ?>
                            <option value="<?= esc($value) ?>" <?= (esc($_POST[$filterKey] ?? $filterConfig['default'])) == $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                        
                    <?php elseif ($filterConfig['source'] === 'stock_locations'): ?>
                        <!-- Stock Locations -->
                        <option value="all">All Locations</option>
                        <?php foreach ($locations as $locationId => $locationName): ?>
                            <option value="<?= esc($locationId) ?>" <?= (esc($_POST[$filterKey] ?? '')) == $locationId ? 'selected' : '' ?>>
                                <?= $locationName ?>
                            </option>
                        <?php endforeach; ?>
                        
                    <?php elseif ($filterConfig['source'] === 'categories'): ?>
                        <!-- Categories -->
                        <option value="all">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category->category_id) ?>" <?= (esc($_POST[$filterKey] ?? '')) == $category->category_id ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
            <?php elseif ($filterConfig['type'] === 'autocomplete'): ?>
                <!-- Autocomplete Filter -->
                <div class="autocomplete-container">
                    <input 
                        type="text" 
                        id="filter_<?= $filterKey ?>_search" 
                        class="form-control"
                        placeholder="Search <?= strtolower($filterConfig['label']) ?>..."
                        autocomplete="off"
                        <?= ($filterConfig['required'] ?? false) ? 'required' : '' ?>
                    >
                    <input 
                        type="hidden" 
                        name="<?= $filterKey ?>" 
                        id="filter_<?= $filterKey ?>"
                        value="<?= esc($_POST[$filterKey] ?? '') ?>"
                    >
                    <div class="autocomplete-results" id="autocomplete_<?= $filterKey ?>"></div>
                </div>
                <script>
                // Initialize autocomplete for <?= $filterKey ?>
                initAutocomplete('<?= $filterKey ?>', '<?= $filterConfig['source'] ?>');
                </script>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>



<script>
// Date Range Shortcuts
function setDateRange(period) {
    const today = new Date();
    let startDate, endDate;
    
    switch(period) {
        case 'today':
            startDate = endDate = today;
            break;
        case 'week':
            startDate = new Date(today.setDate(today.getDate() - today.getDay()));
            endDate = new Date();
            break;
        case 'month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date();
            break;
        case 'year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date();
            break;
    }
    
    document.querySelector('input[name="start_date"]').value = formatDate(startDate);
    document.querySelector('input[name="end_date"]').value = formatDate(endDate);
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Autocomplete Functionality
let autocompleteTimers = {};

function initAutocomplete(filterKey, source) {
    const searchInput = document.getElementById(`filter_${filterKey}_search`);
    const hiddenInput = document.getElementById(`filter_${filterKey}`);
    const resultsContainer = document.getElementById(`autocomplete_${filterKey}`);
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timer
        if (autocompleteTimers[filterKey]) {
            clearTimeout(autocompleteTimers[filterKey]);
        }
        
        if (query.length < 2) {
            resultsContainer.classList.remove('active');
            return;
        }
        
        // Debounce search
        autocompleteTimers[filterKey] = setTimeout(() => {
            searchAutocomplete(filterKey, source, query, resultsContainer, hiddenInput, searchInput);
        }, 300);
    });
    
    // Close on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-container')) {
            resultsContainer.classList.remove('active');
        }
    });
}

async function searchAutocomplete(filterKey, source, query, resultsContainer, hiddenInput, searchInput) {
    try {
        const response = await fetch(`<?= base_url() ?>/${source}/suggest?term=${encodeURIComponent(query)}`);
        const results = await response.json();
        
        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="autocomplete-item u-color-text-tertiary">No results found</div>';
        } else {
            resultsContainer.innerHTML = results.map(item => 
                `<div class="autocomplete-item" data-value="${item.value}" data-label="${item.label}">
                    ${item.label}
                </div>`
            ).join('');
            
            // Add click handlers
            resultsContainer.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', function() {
                    hiddenInput.value = this.dataset.value;
                    searchInput.value = this.dataset.label;
                    resultsContainer.classList.remove('active');
                });
            });
        }
        
        resultsContainer.classList.add('active');
    } catch (error) {
        console.error('Autocomplete error:', error);
    }
}
</script>
