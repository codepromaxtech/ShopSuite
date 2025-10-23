/**
 * Modern Table Manager
 * Combines old table_support functionality with new modern features
 * Full backward compatibility with enhanced features
 */

class TableManager {
    constructor(options = {}) {
        this.options = {
            resource: options.resource || '',
            headers: options.headers || [],
            pageSize: options.pageSize || 20,
            uniqueId: options.uniqueId || 'id',
            employee_id: options.employee_id || null,
            enableActions: options.enableActions || null,
            onLoadSuccess: options.onLoadSuccess || null,
            load_callback: options.load_callback || null,
            selector: options.selector || '#table',
            toolbarSelector: options.toolbarSelector || '#toolbar'
        };
        
        this.table = null;
        this.selectedRows = [];
    }
    
    /**
     * Initialize the table with Bootstrap Table
     */
    init() {
        const exportSuffix = new Date().toISOString().slice(0, 16).replace(/(-|\s*|T|:)*/g, "");
        
        $(this.options.selector)
            .addClass("table-striped table-bordered table-hover")
            .bootstrapTable({
                columns: this.options.headers,
                stickyHeader: true,
                url: `${this.options.resource}/search`,
                sidePagination: 'server',
                selectItemName: 'btSelectItem',
                pageSize: this.options.pageSize,
                pagination: true,
                search: this.options.resource ? true : false,
                showColumns: true,
                clickToSelect: true,
                showExport: true,
                exportDataType: 'basic',
                exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                exportOptions: {
                    fileName: this.options.resource.replace(/.*\/(.*?)$/g, '$1') + "_" + exportSuffix
                },
                toolbar: this.options.toolbarSelector,
                uniqueId: this.options.uniqueId,
                trimOnSearch: false,
                queryParamsType: 'limit',
                iconSize: 'sm',
                silentSort: true,
                paginationVAlign: 'bottom',
                escape: true,
                
                // Event handlers
                onCheck: () => this.enableActions(),
                onUncheck: () => this.enableActions(),
                onCheckAll: () => this.enableActions(),
                onUncheckAll: () => this.enableActions(),
                onLoadSuccess: (response) => this.handleLoadSuccess(response),
                onPageChange: (response) => {
                    this.handleLoadSuccess(response);
                    this.enableActions();
                },
                onColumnSwitch: (field, checked) => this.toggleColumnVisibility(field, checked)
            });
        
        this.table = $(this.options.selector).data('bootstrap.table');
        this.enableActions();
        this.initDeleteButton();
        this.initRestoreButton();
        this.restoreColumnVisibility();
        
        // Initialize dialog support for modal buttons
        dialog_support.init("button.modal-dlg, a.modal-dlg");
        
        return this;
    }
    
    /**
     * Enable/disable toolbar buttons based on selection
     */
    enableActions() {
        const selectionEmpty = this.getSelectedIds().length === 0;
        $(`${this.options.toolbarSelector} button:not(.dropdown-toggle)`).attr('disabled', selectionEmpty);
        
        // Call custom callback
        if (typeof this.options.enableActions === 'function') {
            this.options.enableActions();
        }
    }
    
    /**
     * Get selected row IDs
     */
    getSelectedIds() {
        if (!this.table) return [];
        
        return this.table.getSelections().map(element => {
            const id = element[this.options.uniqueId];
            return id !== '-' ? id : null;
        }).filter(id => id !== null);
    }
    
    /**
     * Get selected rows (DOM elements)
     */
    getSelectedRows() {
        return $(`${this.options.selector} td input:checkbox:checked`).parents("tr");
    }
    
    /**
     * Highlight row with animation
     */
    highlightRow(ids, color = '#e1ffdd') {
        ids = Array.isArray(ids) ? ids : String(ids).split(":");
        
        ids.forEach(id => {
            const selector = `tr[data-uniqueid='${id}']`;
            $(selector).each((index, element) => {
                const original = $(element).css('backgroundColor');
                $(element).find("td")
                    .animate({backgroundColor: color}, "slow", "linear")
                    .delay(5000)
                    .animate({backgroundColor: original}, "slow", "linear");
            });
        });
    }
    
    /**
     * Delete action with confirmation
     */
    doDelete(url = null, ids = null) {
        return this.doAction('delete', url, ids);
    }
    
    /**
     * Restore action with confirmation
     */
    doRestore(url = null, ids = null) {
        return this.doAction('restore', url, ids);
    }
    
    /**
     * Generic action handler (delete, restore, etc.)
     */
    async doAction(action, url = null, ids = null) {
        const actionIds = ids || this.getSelectedIds();
        
        if (actionIds.length === 0) {
            showNotification('Please select at least one item', 'warning');
            return false;
        }
        
        // Use modern confirm dialog
        const confirmed = await confirmAction(
            `${action.charAt(0).toUpperCase() + action.slice(1)} ${actionIds.length} item(s)?`,
            `Are you sure you want to ${action} the selected items?`,
            action.charAt(0).toUpperCase() + action.slice(1)
        );
        
        if (!confirmed) return false;
        
        // Show loading
        showLoading(`${action.charAt(0).toUpperCase() + action.slice(1)}ing...`);
        
        try {
            const response = await $.post(
                `${url || this.options.resource}/${action}`,
                {'ids[]': actionIds}
            );
            
            hideLoading();
            
            if (response.success) {
                // Animate rows out
                const selector = ids ? `tr[data-uniqueid='${ids}']` : this.getSelectedRows();
                this.table.collapseAllRows();
                
                $(selector).each((index, element) => {
                    $(element).find("td")
                        .animate({backgroundColor: "green"}, 1200, "linear")
                        .end()
                        .animate({opacity: 0}, 1200, "linear", () => {
                            this.table.remove({
                                field: this.options.uniqueId,
                                values: actionIds
                            });
                            
                            if (index === $(selector).length - 1) {
                                this.refresh();
                                this.enableActions();
                            }
                        });
                });
                
                showNotification(response.message, 'success');
            } else {
                showNotification(response.message, 'error');
            }
        } catch (error) {
            hideLoading();
            showNotification(`${action} failed: ${error.message}`, 'error');
        }
        
        return false;
    }
    
    /**
     * Refresh table data
     */
    refresh() {
        if (this.table) {
            this.table.refresh();
        }
    }
    
    /**
     * Handle load success
     */
    handleLoadSuccess(response) {
        if (typeof this.options.load_callback === 'function') {
            this.options.load_callback();
            this.options.load_callback = undefined;
        }
        
        // Reinitialize dialog support for new modal links
        dialog_support.init("a.modal-dlg");
        
        if (typeof this.options.onLoadSuccess === 'function') {
            this.options.onLoadSuccess(response);
        }
        
        this.enableActions();
    }
    
    /**
     * Handle form submit (create/update)
     */
    handleSubmit(resource, response) {
        const id = response.id !== undefined ? String(response.id) : "";
        
        if (!response.success) {
            showNotification(response.message, 'error');
            return false;
        }
        
        const selector = id.split(":").map(i => `tr[data-uniqueid='${i}']`);
        const rows = $(selector.join(",")).length;
        
        // If updating existing rows (and not too many)
        if (rows > 0 && rows < 15) {
            const ids = id.split(":");
            
            $.get(`${resource}/row/${id}`, {}, (rowData) => {
                selector.forEach((sel, index) => {
                    const rowId = $(sel).data('uniqueid');
                    this.table.updateByUniqueId({
                        id: rowId,
                        row: rowData[rowId] || rowData
                    });
                });
                
                dialog_support.init("a.modal-dlg");
                this.highlightRow(ids);
            }, 'json');
        } else {
            // Refresh and highlight after load
            this.options.load_callback = () => {
                this.enableActions();
                this.highlightRow(id.split(":"));
            };
            this.refresh();
        }
        
        showNotification(response.message, 'success');
        return false;
    }
    
    /**
     * Toggle column visibility and save to localStorage
     */
    toggleColumnVisibility(field, checked) {
        if (!this.options.employee_id) return;
        
        let userSettings = localStorage.getItem(this.options.employee_id);
        userSettings = userSettings ? JSON.parse(userSettings) : {};
        userSettings[this.options.resource] = userSettings[this.options.resource] || {};
        userSettings[this.options.resource][field] = checked;
        localStorage.setItem(this.options.employee_id, JSON.stringify(userSettings));
        
        dialog_support.init("a.modal-dlg");
    }
    
    /**
     * Restore column visibility from localStorage
     */
    restoreColumnVisibility() {
        if (!this.options.employee_id || !this.table) return;
        
        const userSettings = localStorage.getItem(this.options.employee_id);
        if (!userSettings) return;
        
        try {
            const settings = JSON.parse(userSettings);
            const resourceSettings = settings[this.options.resource];
            
            if (resourceSettings) {
                Object.entries(resourceSettings).forEach(([field, visible]) => {
                    if (visible) {
                        this.table.showColumn(field);
                    } else {
                        this.table.hideColumn(field);
                    }
                });
            }
        } catch (error) {
            console.error('Failed to restore column visibility:', error);
        }
    }
    
    /**
     * Initialize delete button
     */
    initDeleteButton() {
        $("#delete").off('click').on('click', () => {
            this.doDelete();
        });
    }
    
    /**
     * Initialize restore button
     */
    initRestoreButton() {
        $("#restore").off('click').on('click', () => {
            this.doRestore();
        });
    }
    
    /**
     * Create submit handler with custom URL
     */
    createSubmitHandler(url) {
        return (resource, response) => this.handleSubmit(url || resource, response);
    }
}

// ===================================================================
// BACKWARD COMPATIBILITY - Maintain old API
// ===================================================================

// Forcefully override the old table_support from gulp bundle
(function($) {
    'use strict';
    
window.table_support = {
    _manager: null,
    
    init: function(options) {
        console.log('✅ table_support.init() called with options:', options);
        this._manager = new TableManager(options);
        this._manager.init();
        console.log('✅ TableManager initialized successfully');
    },
    
    refresh: function() {
        this._manager && this._manager.refresh();
    },
    
    selected_ids: function() {
        return this._manager ? this._manager.getSelectedIds() : [];
    },
    
    do_delete: function(url, ids) {
        return this._manager ? this._manager.doDelete(url, ids) : false;
    },
    
    do_restore: function(url, ids) {
        return this._manager ? this._manager.doRestore(url, ids) : false;
    },
    
    handle_submit: function(resource, response) {
        return this._manager ? this._manager.handleSubmit(resource, response) : false;
    },
    
    submit_handler: function(url) {
        if (this._manager) {
            this.handle_submit = this._manager.createSubmitHandler(url);
        }
    }
};

// Number sorter utility for tables
window.number_sorter = function(a, b) {
    a = +a.replace(/[^\-0-9]+/g, '');
    b = +b.replace(/[^\-0-9]+/g, '');
    return a - b;
};

})(jQuery); // Close IIFE

console.log('✨ Modern Table Manager Loaded');
