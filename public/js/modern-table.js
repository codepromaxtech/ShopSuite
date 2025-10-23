/**
 * Modern Table Management System
 * Pure Bootstrap 5 + ES6+ - No jQuery dependencies (except Bootstrap Table)
 * Completely NEW implementation (old code used only as reference)
 */

class ModernTableManager {
    constructor(options) {
        this.options = {
            selector: options.selector || '#table',
            toolbarSelector: options.toolbarSelector || '#toolbar',
            resource: options.resource || '',
            headers: options.headers || [],
            pageSize: options.pageSize || 20,
            uniqueId: options.uniqueId || 'id',
            employeeId: options.employeeId || null,
            onLoadSuccess: options.onLoadSuccess || null,
            onCheck: options.onCheck || null,
            onUncheck: options.onUncheck || null
        };
        
        this.table = null;
        this.$table = $(this.options.selector);
    }
    
    /**
     * Initialize the table
     */
    init() {
        const exportSuffix = new Date().toISOString().slice(0, 16).replace(/[-T:]/g, '');
        
        // Initialize Bootstrap Table
        this.$table.bootstrapTable({
            url: `${this.options.resource}/search`,
            columns: this.options.headers,
            uniqueId: this.options.uniqueId,
            
            // Table features
            classes: 'table table-hover table-striped',
            striped: true,
            search: true,
            searchHighlight: true,
            showSearchClearButton: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            showExport: false, // We have custom export buttons
            
            // Selection
            clickToSelect: true,
            selectItemName: 'btSelectItem',
            
            // Pagination
            pagination: true,
            sidePagination: 'server',
            pageSize: this.options.pageSize,
            pageList: [10, 20, 50, 100, 'All'],
            paginationVAlign: 'bottom',
            paginationDetailHAlign: 'left',
            
            // Toolbar
            toolbar: this.options.toolbarSelector,
            
            // Query params
            queryParamsType: 'limit',
            queryParams: params => {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search,
                    sort: params.sort,
                    order: params.order
                };
            },
            
            // Sorting
            sortable: true,
            silentSort: false,
            
            // Sticky header
            stickyHeader: true,
            stickyHeaderOffsetY: 60,
            
            // Other options
            iconSize: 'sm',
            escape: true,
            trimOnSearch: false,
            
            // Events
            onCheck: (row, $element) => {
                this.updateToolbarButtons();
                if (this.options.onCheck) this.options.onCheck(row, $element);
            },
            
            onUncheck: (row, $element) => {
                this.updateToolbarButtons();
                if (this.options.onUncheck) this.options.onUncheck(row, $element);
            },
            
            onCheckAll: rows => {
                this.updateToolbarButtons();
            },
            
            onUncheckAll: rows => {
                this.updateToolbarButtons();
            },
            
            onLoadSuccess: data => {
                this.updateToolbarButtons();
                this.restoreColumnVisibility();
                this.initializeModalLinks();
                
                if (this.options.onLoadSuccess) {
                    this.options.onLoadSuccess(data);
                }
            },
            
            onColumnSwitch: (field, checked) => {
                this.saveColumnVisibility(field, checked);
            },
            
            onPageChange: (number, size) => {
                this.updateToolbarButtons();
            }
        });
        
        this.table = this.$table.data('bootstrap.table');
        
        // Initialize action buttons
        this.initializeDeleteButton();
        this.initializeRestoreButton();
        this.updateToolbarButtons();
        
        console.log('✅ Modern Table initialized successfully');
        return this;
    }
    
    /**
     * Update toolbar buttons based on selection
     */
    updateToolbarButtons() {
        const selections = this.getSelections();
        const hasSelection = selections.length > 0;
        
        // Enable/disable action buttons
        $(`${this.options.toolbarSelector} button:not(.dropdown-toggle):not(.no-disable)`).each(function() {
            const $btn = $(this);
            // Only disable buttons that need selection
            if ($btn.attr('id') === 'delete' || 
                $btn.attr('id')?.startsWith('bulk-') || 
                $btn.hasClass('requires-selection')) {
                $btn.prop('disabled', !hasSelection);
            }
        });
    }
    
    /**
     * Get selected rows
     */
    getSelections() {
        return this.table ? this.table.getSelections() : [];
    }
    
    /**
     * Get selected IDs
     */
    getSelectedIds() {
        const selections = this.getSelections();
        return selections.map(row => row[this.options.uniqueId]).filter(id => id && id !== '-');
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
     * Delete selected rows
     */
    async deleteSelected() {
        const ids = this.getSelectedIds();
        
        if (ids.length === 0) {
            showNotification('Please select items to delete', 'warning');
            return;
        }
        
        const confirmed = await Swal.fire({
            title: `Delete ${ids.length} item(s)?`,
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        });
        
        if (!confirmed.isConfirmed) return;
        
        showLoading('Deleting...');
        
        try {
            const response = await $.post(
                `${this.options.resource}/delete`,
                { 'ids[]': ids }
            );
            
            hideLoading();
            
            if (response.success) {
                // Animate rows out
                const selections = this.getSelections();
                const rows = selections.map(row => 
                    this.$table.find(`tr[data-uniqueid="${row[this.options.uniqueId]}"]`)
                );
                
                rows.forEach($row => {
                    $row.find('td').css('background-color', '#10b981');
                    $row.fadeOut(1000, () => {
                        this.table.remove({
                            field: this.options.uniqueId,
                            values: ids
                        });
                    });
                });
                
                setTimeout(() => {
                    this.refresh();
                    showNotification(response.message, 'success');
                }, 1000);
            } else {
                showNotification(response.message, 'error');
            }
        } catch (error) {
            hideLoading();
            showNotification('Delete failed: ' + error.message, 'error');
        }
    }
    
    /**
     * Restore selected rows
     */
    async restoreSelected() {
        const ids = this.getSelectedIds();
        
        if (ids.length === 0) {
            showNotification('Please select items to restore', 'warning');
            return;
        }
        
        showLoading('Restoring...');
        
        try {
            const response = await $.post(
                `${this.options.resource}/restore`,
                { 'ids[]': ids }
            );
            
            hideLoading();
            
            if (response.success) {
                this.refresh();
                showNotification(response.message, 'success');
            } else {
                showNotification(response.message, 'error');
            }
        } catch (error) {
            hideLoading();
            showNotification('Restore failed: ' + error.message, 'error');
        }
    }
    
    /**
     * Highlight specific rows
     */
    highlightRows(ids) {
        if (!Array.isArray(ids)) ids = [ids];
        
        ids.forEach(id => {
            const $row = this.$table.find(`tr[data-uniqueid="${id}"]`);
            if ($row.length) {
                const originalBg = $row.css('background-color');
                $row.find('td')
                    .animate({ backgroundColor: '#10b981' }, 500)
                    .delay(3000)
                    .animate({ backgroundColor: originalBg }, 500);
            }
        });
    }
    
    /**
     * Handle form submission (create/update)
     */
    handleSubmit(response) {
        if (!response.success) {
            showNotification(response.message, 'error');
            return;
        }
        
        // Close any open modals
        const modalElement = document.querySelector('.modal.show');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide();
        }
        
        // Refresh and highlight
        this.refresh();
        
        if (response.id) {
            const ids = String(response.id).split(':');
            setTimeout(() => {
                this.highlightRows(ids);
            }, 500);
        }
        
        showNotification(response.message, 'success');
    }
    
    /**
     * Save column visibility to localStorage
     */
    saveColumnVisibility(field, checked) {
        if (!this.options.employeeId) return;
        
        const key = `table_columns_${this.options.employeeId}`;
        let settings = JSON.parse(localStorage.getItem(key) || '{}');
        
        if (!settings[this.options.resource]) {
            settings[this.options.resource] = {};
        }
        
        settings[this.options.resource][field] = checked;
        localStorage.setItem(key, JSON.stringify(settings));
    }
    
    /**
     * Restore column visibility from localStorage
     */
    restoreColumnVisibility() {
        if (!this.options.employeeId || !this.table) return;
        
        const key = `table_columns_${this.options.employeeId}`;
        const settings = JSON.parse(localStorage.getItem(key) || '{}');
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
    }
    
    /**
     * Initialize delete button
     */
    initializeDeleteButton() {
        const $deleteBtn = $('#delete');
        if ($deleteBtn.length) {
            $deleteBtn.off('click').on('click', () => this.deleteSelected());
        }
    }
    
    /**
     * Initialize restore button
     */
    initializeRestoreButton() {
        const $restoreBtn = $('#restore');
        if ($restoreBtn.length) {
            $restoreBtn.off('click').on('click', () => this.restoreSelected());
        }
    }
    
    /**
     * Initialize modal links (for edit/view buttons in table)
     */
    initializeModalLinks() {
        // Reinitialize modal links within the table
        this.$table.find('a[data-bs-toggle="modal"], button[data-bs-toggle="modal"]').each((index, element) => {
            const $link = $(element);
            const href = $link.attr('href') || $link.data('href');
            
            if (href) {
                $link.off('click').on('click', async (e) => {
                    e.preventDefault();
                    await openModal(href, $link.attr('title') || 'Form');
                });
            }
        });
    }
}

// Export to window
window.ModernTableManager = ModernTableManager;

console.log('✅ Modern Table Manager loaded');
