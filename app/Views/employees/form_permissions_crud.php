<?php
/**
 * MODERN CRUD PERMISSIONS INTERFACE
 * Proper action-based permissions (View, Add, Update, Delete)
 */
?>

<style>
.permission-module-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s;
}
.permission-module-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13,110,253,0.1);
}
.permission-module-card.disabled {
    opacity: 0.5;
    background: #f8f9fa;
}
.module-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e9ecef;
}
.module-toggle {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0d6efd, #0a58ca);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1rem;
}
.module-info {
    flex-grow: 1;
}
.module-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.25rem;
}
.module-description {
    font-size: 0.875rem;
    color: #6c757d;
}
.crud-permissions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.75rem;
}
.permission-checkbox {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    transition: all 0.2s;
}
.permission-checkbox:hover {
    background: #e9ecef;
}
.permission-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 0.5rem;
    cursor: pointer;
}
.permission-checkbox label {
    margin: 0;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
}
.permission-checkbox.checked {
    background: #e7f1ff;
    border: 1px solid #0d6efd;
}
.permission-icon {
    margin-right: 0.25rem;
}
.menu-group-selector {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    font-size: 0.875rem;
}
</style>

<div class="alert alert-info mb-4">
    <i class="bi bi-info-circle me-2"></i>
    <strong>How Permissions Work:</strong>
    <ul class="mb-0 mt-2">
        <li><strong>View:</strong> Can see and access the module</li>
        <li><strong>Add:</strong> Can create new records</li>
        <li><strong>Update:</strong> Can edit existing records</li>
        <li><strong>Delete:</strong> Can remove records</li>
        <li><strong>Special:</strong> Module-specific actions (export, manage stock, etc.)</li>
    </ul>
</div>

<div id="crud_permission_list">
    <?php
    // Group modules by category
    $module_categories = [
        'Main Modules' => ['customers', 'items', 'sales', 'suppliers', 'receivings'],
        'Management' => ['employees', 'giftcards', 'expenses', 'cashups'],
        'System' => ['config', 'roles', 'backups', 'taxes', 'attributes', 'expenses_categories'],
        'Tools' => ['reports', 'messages']
    ];
    
    // Define CRUD actions with icons
    $crud_actions = [
        'view' => ['icon' => 'bi-eye', 'label' => 'View', 'color' => 'info'],
        'add' => ['icon' => 'bi-plus-circle', 'label' => 'Add', 'color' => 'success'],
        'update' => ['icon' => 'bi-pencil-square', 'label' => 'Update', 'color' => 'warning'],
        'delete' => ['icon' => 'bi-trash', 'label' => 'Delete', 'color' => 'danger']
    ];
    
    // Special permissions for specific modules
    $special_permissions = [
        'items' => ['manage_stock' => 'Manage Stock', 'export' => 'Export'],
        'sales' => ['change_price' => 'Change Price', 'refund' => 'Refund', 'export' => 'Export'],
        'customers' => ['export' => 'Export'],
        'suppliers' => ['export' => 'Export'],
        'reports' => ['export' => 'Export', 'sales' => 'Sales Reports', 'inventory' => 'Inventory Reports'],
        'messages' => ['send' => 'Send Messages'],
        'backups' => ['create' => 'Create', 'download' => 'Download', 'restore' => 'Restore'],
        'config' => ['backup' => 'Backup Settings'],
        'employees' => ['manage_permissions' => 'Manage Permissions']
    ];
    
    foreach ($module_categories as $category => $modules):
    ?>
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-3" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px;">
                <?= $category ?>
            </h6>
            
            <?php foreach ($modules as $module_id):
                // Find module info
                $module = null;
                foreach ($all_modules as $m) {
                    if ($m->module_id === $module_id) {
                        $module = $m;
                        break;
                    }
                }
                
                if (!$module) continue;
                
                $module_checked = $module->grant == 1;
            ?>
                <div class="permission-module-card <?= $module_checked ? '' : 'disabled' ?>" data-module="<?= $module_id ?>">
                    <div class="module-header">
                        <div class="module-toggle">
                            <i class="<?= getModuleIcon($module_id) ?>"></i>
                        </div>
                        <div class="module-info">
                            <div class="module-name"><?= lang("Module.$module_id") ?></div>
                            <div class="module-description"><?= lang("Module.{$module_id}_desc") ?></div>
                        </div>
                        <div class="form-check form-switch" style="font-size: 1.5rem;">
                            <?= form_checkbox([
                                'name' => "grant_$module_id",
                                'id' => "grant_$module_id",
                                'value' => $module_id,
                                'checked' => $module_checked,
                                'class' => 'form-check-input module-master-switch',
                                'role' => 'switch'
                            ]) ?>
                        </div>
                        <?= form_hidden("menu_group_$module_id", $module->menu_group ?? 'both') ?>
                    </div>
                    
                    <div class="crud-permissions">
                        <?php
                        // Standard CRUD permissions
                        foreach ($crud_actions as $action => $action_info):
                            $permission_id = "{$module_id}_{$action}";
                            $is_granted = false;
                            
                            // Check if this permission exists and is granted
                            foreach ($all_subpermissions as $perm) {
                                if ($perm->permission_id === $permission_id) {
                                    $is_granted = $perm->grant == 1;
                                    break;
                                }
                            }
                        ?>
                            <div class="permission-checkbox <?= $is_granted ? 'checked' : '' ?>">
                                <?= form_checkbox([
                                    'name' => "grant_$permission_id",
                                    'id' => "grant_$permission_id",
                                    'value' => $permission_id,
                                    'checked' => $is_granted,
                                    'class' => 'crud-permission-checkbox',
                                    'disabled' => !$module_checked
                                ]) ?>
                                <?= form_hidden("menu_group_$permission_id", "--") ?>
                                <label for="grant_<?= $permission_id ?>">
                                    <i class="bi <?= $action_info['icon'] ?> permission-icon text-<?= $action_info['color'] ?>"></i>
                                    <?= $action_info['label'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php
                        // Special permissions for this module
                        if (isset($special_permissions[$module_id])):
                            foreach ($special_permissions[$module_id] as $special_action => $special_label):
                                $permission_id = "{$module_id}_{$special_action}";
                                $is_granted = false;
                                
                                foreach ($all_subpermissions as $perm) {
                                    if ($perm->permission_id === $permission_id) {
                                        $is_granted = $perm->grant == 1;
                                        break;
                                    }
                                }
                        ?>
                                <div class="permission-checkbox <?= $is_granted ? 'checked' : '' ?>">
                                    <?= form_checkbox([
                                        'name' => "grant_$permission_id",
                                        'id' => "grant_$permission_id",
                                        'value' => $permission_id,
                                        'checked' => $is_granted,
                                        'class' => 'crud-permission-checkbox',
                                        'disabled' => !$module_checked
                                    ]) ?>
                                    <?= form_hidden("menu_group_$permission_id", "--") ?>
                                    <label for="grant_<?= $permission_id ?>">
                                        <i class="bi bi-star permission-icon text-primary"></i>
                                        <?= $special_label ?>
                                    </label>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
$(document).ready(function() {
    console.log('🔐 CRUD Permissions Interface Loaded');
    
    // Handle module master switch
    $('.module-master-switch').on('change', function() {
        const $card = $(this).closest('.permission-module-card');
        const isChecked = $(this).is(':checked');
        const $crudCheckboxes = $card.find('.crud-permission-checkbox');
        
        // Enable/disable all CRUD checkboxes
        $crudCheckboxes.prop('disabled', !isChecked);
        
        // Toggle card appearance
        $card.toggleClass('disabled', !isChecked);
        
        // If disabling, uncheck all sub-permissions
        if (!isChecked) {
            $crudCheckboxes.prop('checked', false);
            $card.find('.permission-checkbox').removeClass('checked');
        }
    });
    
    // Handle CRUD checkbox visual feedback
    $('.crud-permission-checkbox').on('change', function() {
        const $container = $(this).closest('.permission-checkbox');
        $container.toggleClass('checked', $(this).is(':checked'));
    });
    
    // Select All helper for each module
    $('.permission-module-card').each(function() {
        const $card = $(this);
        const $masterSwitch = $card.find('.module-master-switch');
        
        // Add "Select All" button
        const $selectAllBtn = $('<button type="button" class="btn btn-sm btn-outline-primary ms-2">Select All</button>');
        $selectAllBtn.on('click', function(e) {
            e.preventDefault();
            if ($masterSwitch.is(':checked')) {
                $card.find('.crud-permission-checkbox:not(:disabled)').prop('checked', true).trigger('change');
            }
        });
        
        $card.find('.module-header .form-check').after($selectAllBtn);
    });
});
</script>
