<?php
/**
 * MODERN ATTRIBUTES FORM - Create/Edit Attribute Definition
 * @var string $definition_id
 * @var object $definition_info
 * @var array $definition_group
 * @var array $definition_flags
 * @var array $selected_definition_flags
 * @var string $controller_name
 * @var array $definition_values
 */

$is_new = ($definition_id == 0);
$is_category = ($definition_id == -1);

$title = ($is_new ? 'Add New' : 'Edit') . ' Attribute - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            <div>
                <h1><?= $is_new ? 'Add New' : 'Edit' ?> Attribute</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('attributes') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Attributes
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('attributes') ?>">Attributes</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $is_new ? 'Add' : 'Edit' ?></div>
    </div>
</div>

<?= form_open("attributes/saveDefinition/$definition_id", ['id' => 'attribute_form', 'class' => 'form-modern']) ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Basic Information -->
        <div class="card u-margin-bottom-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="definition_name" class="form-label form-label-required">Attribute Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="definition_name" 
                           name="definition_name" 
                           value="<?= esc($definition_info->definition_name) ?>"
                           <?= $is_category ? 'readonly' : '' ?>
                           required>
                    <small class="form-text">A descriptive name for this attribute</small>
                </div>
                
                <div class="form-group">
                    <label for="definition_type" class="form-label form-label-required">Attribute Type</label>
                    <select class="form-control form-select" 
                            id="definition_type" 
                            name="definition_type"
                            <?= $is_category ? 'disabled' : '' ?>
                            required>
                        <?php foreach (DEFINITION_TYPES as $key => $type): ?>
                            <option value="<?= $key ?>" <?= array_search($definition_info->definition_type, DEFINITION_TYPES) == $key ? 'selected' : '' ?>>
                                <?= esc($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Choose the data type for this attribute</small>
                </div>
                
                <?php if (!empty($definition_group) && !$is_category): ?>
                    <div class="form-group" id="definition_group_container">
                        <label for="definition_group" class="form-label">Parent Group</label>
                        <select class="form-control form-select" id="definition_group" name="definition_group">
                            <option value="">None</option>
                            <?php foreach ($definition_group as $id => $name): ?>
                                <option value="<?= $id ?>" <?= $definition_info->definition_fk == $id ? 'selected' : '' ?>>
                                    <?= esc($name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text">Optional: Group this attribute under a parent</small>
                    </div>
                <?php endif; ?>
                
                <div class="form-group d-none" id="definition_unit_container">
                    <label for="definition_unit" class="form-label">Unit</label>
                    <input type="text" 
                           class="form-control" 
                           id="definition_unit" 
                           name="definition_unit" 
                           value="<?= esc($definition_info->definition_unit) ?>">
                    <small class="form-text">Unit of measurement (e.g., cm, kg, ml)</small>
                </div>
                
                <?php if (!$is_category): ?>
                    <div class="form-group d-none" id="definition_flags_container">
                        <label class="form-label">Display Flags</label>
                        <div class="u-display-flex_flex-direction-column_gap-1">
                            <?php foreach ($definition_flags as $flag_key => $flag_label): ?>
                                <label class="u-display-flex_align-items-center_gap-sp">
                                    <input type="checkbox" 
                                           name="definition_flags[]" 
                                           value="<?= $flag_key ?>"
                                           <?= isset($selected_definition_flags[$flag_key]) ? 'checked' : '' ?>>
                                    <span><?= esc($flag_label) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Dropdown/Checkbox Values -->
        <div class="card d-none" id="definition_values_container">
            <div class="card-header">
                <h3 class="card-header-title">Dropdown/Checkbox Values</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="definition_value" class="form-label">Add Value</label>
                    <div class="u-display-flex_gap-space-2">
                        <input type="text" 
                               class="form-control" 
                               id="definition_value" 
                               name="definition_value"
                               placeholder="Enter value and press Add">
                        <button type="button" class="btn btn-primary" id="add_attribute_value">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add
                        </button>
                    </div>
                    <small class="form-text">Note: Cannot contain pipe (|) or underscore (_) characters</small>
                </div>
                
                <div class="u-margin-top-space-4" id="definition_list_group">
                    <!-- Values will be added here dynamically -->
                </div>
                
                <div class="u-padding-space-8_text-align-center_colo" id="empty_values_state">
                    <svg class="u-margin-0autospace-4" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p>No values added yet</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <!-- Actions -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?= $is_new ? 'Create' : 'Update' ?> Attribute
                </button>
                
                <a href="<?= base_url('attributes') ?>" class="btn btn-outline btn-block mt-space-3">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
            </div>
        </div>
        
        <!-- Attribute Type Info -->
        <div class="card u-margin-top-space-6">
            <div class="card-header">
                <h3 class="card-header-title">Attribute Types</h3>
            </div>
            <div class="card-body">
                <div class="u-font-size-text-sm_color-text-secondary">
                    <p class="u-margin-bottom-space-2"><strong>DROPDOWN:</strong> Select one value from a list</p>
                    <p class="u-margin-bottom-space-2"><strong>CHECKBOX:</strong> Select multiple values</p>
                    <p class="u-margin-bottom-space-2"><strong>DATE:</strong> Date picker input</p>
                    <p class="u-margin-bottom-space-2"><strong>DECIMAL:</strong> Numeric value with unit</p>
                    <p><strong>GROUP:</strong> Container for other attributes</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>



<script>
let values = [];
const definitionId = <?= esc($definition_id, 'js') ?>;
const isNew = definitionId == 0;
const isCategory = definitionId == -1;

document.addEventListener('DOMContentLoaded', function() {
    setupTypeHandling();
    setupValueHandling();
    loadExistingValues();
    
    // Show/hide fields based on type
    document.getElementById('definition_type').addEventListener('change', showHideFields);
    showHideFields();
});

function setupTypeHandling() {
    const typeSelect = document.getElementById('definition_type');
    const selectedType = typeSelect.options[typeSelect.selectedIndex].text;
    
    // Disable certain types based on conditions
    if (selectedType === 'DATE' || (selectedType === 'GROUP' && !isNew) || selectedType === 'DECIMAL') {
        typeSelect.disabled = true;
    }
}

function showHideFields() {
    const typeSelect = document.getElementById('definition_type');
    const selectedValue = typeSelect.value;
    const selectedType = typeSelect.options[typeSelect.selectedIndex].text;
    
    // Show/hide values container for DROPDOWN and CHECKBOX
    const valuesContainer = document.getElementById('definition_values_container');
    if (valuesContainer) {
        valuesContainer.style.display = (selectedType === 'DROPDOWN' || selectedType === 'CHECKBOX') ? 'block' : 'none';
    }
    
    // Show/hide unit container for DECIMAL
    const unitContainer = document.getElementById('definition_unit_container');
    if (unitContainer) {
        unitContainer.style.display = (selectedType === 'DECIMAL') ? 'block' : 'none';
    }
    
    // Show/hide flags container (not for GROUP)
    const flagsContainer = document.getElementById('definition_flags_container');
    if (flagsContainer && !isCategory) {
        flagsContainer.style.display = (selectedType !== 'GROUP') ? 'block' : 'none';
    }
}

function setupValueHandling() {
    const addButton = document.getElementById('add_attribute_value');
    const valueInput = document.getElementById('definition_value');
    
    if (addButton) {
        addButton.addEventListener('click', () => addAttributeValue());
    }
    
    if (valueInput) {
        valueInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addAttributeValue();
            }
        });
    }
}

function addAttributeValue(value = null) {
    const valueInput = document.getElementById('definition_value');
    const listGroup = document.getElementById('definition_list_group');
    const emptyState = document.getElementById('empty_values_state');
    
    if (!value) {
        value = valueInput.value.trim();
    }
    
    if (!value) return;
    
    // Validate characters
    if (value.match(/(\||_)/g) !== null) {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.showToast('Error', 'Value cannot contain pipe (|) or underscore (_) characters', 'error');
        }
        return;
    }
    
    // Save to server if not new
    if (!isNew) {
        fetch('<?= base_url("attributes/saveAttributeValue") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `definition_id=${definitionId}&attribute_value=${encodeURIComponent(value)}`
        });
    } else {
        values.push(value);
    }
    
    // Add to UI
    const valueItem = document.createElement('div');
    valueItem.className = 'value-item';
    valueItem.innerHTML = `
        <span class="value-item-text">${value}</span>
        <svg class="value-item-remove" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="removeAttributeValue(this, '${value.replace(/'/g, "\\'")}')">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
    `;
    
    listGroup.appendChild(valueItem);
    emptyState.style.display = 'none';
    valueInput.value = '';
    valueInput.focus();
}

function removeAttributeValue(element, value) {
    const valueItem = element.closest('.value-item');
    
    if (isNew) {
        const index = values.indexOf(value);
        if (index > -1) {
            values.splice(index, 1);
        }
    } else {
        fetch('<?= base_url("attributes/DeleteDropdownAttributeValue") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `definition_id=${definitionId}&attribute_value=${encodeURIComponent(value)}`
        });
    }
    
    valueItem.remove();
    
    // Show empty state if no values
    const listGroup = document.getElementById('definition_list_group');
    if (listGroup.children.length === 0) {
        document.getElementById('empty_values_state').style.display = 'block';
    }
}

function loadExistingValues() {
    const definitionValues = <?= json_encode(array_values($definition_values)) ?>;
    const emptyState = document.getElementById('empty_values_state');
    
    if (definitionValues && definitionValues.length > 0) {
        definitionValues.forEach(value => {
            addAttributeValue(value);
        });
        if (emptyState) {
            emptyState.style.display = 'none';
        }
    }
}

// Form submission
document.getElementById('attribute_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Enable all disabled fields before submit
    this.querySelectorAll(':input').forEach(input => {
        input.disabled = false;
    });
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Saving attribute...');
    }
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
        }
        
        if (data.success) {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Success', data.message || 'Attribute saved successfully', 'success');
            }
            setTimeout(() => {
                window.location.href = '<?= base_url("attributes") ?>';
            }, 1000);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to save attribute', 'error');
            }
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
            window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
        }
        console.error('Error:', error);
    });
});
</script>

<?php echo view('layouts/modern_footer'); ?>
