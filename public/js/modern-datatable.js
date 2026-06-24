/**
 * MODERN DATA TABLE - Pure ES6+ Solution
 * No external dependencies except Bootstrap 5 & jQuery (minimal)
 * Replaces Bootstrap Table library completely
 */

class ModernDataTable {
    constructor(selector, options) {
        // Support both (selector, options) and (options) signatures
        if (typeof selector === 'string') {
            // New signature: ('selector', options)
            this.selector = selector;
            this.container = document.querySelector(selector);
            this.tableId = selector.replace('#', '');
            this.options = options || {};
        } else {
            // Old signature: (options)
            options = selector;
            this.tableId = options.tableId || 'dataTable';
            this.selector = '#' + this.tableId;
            this.container = document.getElementById(this.tableId);
            this.options = options;
        }
        
        // Merge with defaults
        this.options = {
            ajax: this.options.ajax || { url: '', dataSrc: 'rows' },
            columns: this.options.columns || [],
            actions: this.options.actions || [],
            uniqueId: this.options.uniqueId || 'id',
            pageSize: this.options.pageSize || 20,
            searchable: this.options.searchable !== false,
            exportable: this.options.exportable !== false,
            onRowClick: this.options.onRowClick || null,
            onLoadComplete: this.options.onLoadComplete || null
        };
        
        // Add actions column automatically if actions are defined
        if (this.options.actions && this.options.actions.length > 0) {
            this.options.columns.push({
                field: '_actions',
                title: 'Actions',
                sortable: false,
                render: (value, row) => this.renderActions(row)
            });
        }
        
        this.currentPage = 1;
        this.totalRecords = 0;
        this.searchTerm = '';
        this.sortColumn = '';
        this.sortOrder = 'asc';
        this.selectedRows = new Set();
        
        this.init();
    }
    
    init() {
        console.log('✅ ModernDataTable initializing for:', this.tableId);
        if (!this.container) {
            console.error('Table container not found:', this.selector);
            return;
        }
        this.buildTable();
        this.attachEventListeners();
        this.loadData();
    }
    
    buildTable() {
        if (!this.container) {
            console.error('Table container not found');
            return;
        }
        
        const html = `
            <!-- Toolbar -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="${this.tableId}-search" 
                                       placeholder="Search...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <button class="btn btn-outline-primary" id="${this.tableId}-refresh">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                                <button class="btn btn-outline-success" id="${this.tableId}-export">
                                    <i class="bi bi-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Table -->
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="${this.tableId}-table">
                        <thead class="table-light">
                            <tr>
                                ${this.options.columns.map(col => `
                                    <th class="${col.sortable !== false ? 'sortable' : ''}" 
                                        data-field="${col.field}">
                                        ${col.title}
                                        ${col.sortable !== false ? '<i class="bi bi-arrow-down-up ms-1"></i>' : ''}
                                    </th>
                                `).join('')}
                            </tr>
                        </thead>
                        <tbody id="${this.tableId}-body">
                            <tr>
                                <td colspan="${this.options.columns.length}" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div id="${this.tableId}-info" class="text-muted">
                                Loading...
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Table pagination">
                                <ul class="pagination pagination-sm justify-content-end mb-0" 
                                    id="${this.tableId}-pagination">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        this.container.innerHTML = html;
    }
    
    attachEventListeners() {
        // Search
        const searchInput = document.getElementById(`${this.tableId}-search`);
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.searchTerm = e.target.value;
                    this.currentPage = 1;
                    this.loadData();
                }, 300);
            });
        }
        
        // Refresh
        const refreshBtn = document.getElementById(`${this.tableId}-refresh`);
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refresh());
        }
        
        // Export
        const exportBtn = document.getElementById(`${this.tableId}-export`);
        if (exportBtn) {
            exportBtn.addEventListener('click', () => this.exportData());
        }
        
        // Sort headers
        document.querySelectorAll(`#${this.tableId} th.sortable`).forEach(th => {
            th.style.cursor = 'pointer';
            th.addEventListener('click', () => {
                const field = th.dataset.field;
                if (this.sortColumn === field) {
                    this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = field;
                    this.sortOrder = 'asc';
                }
                this.updateSortIcons();
                this.loadData();
            });
        });
    }
    
    updateSortIcons() {
        document.querySelectorAll(`#${this.tableId} th.sortable i`).forEach(icon => {
            icon.className = 'bi bi-arrow-down-up ms-1';
        });
        
        const sortedHeader = document.querySelector(`#${this.tableId} th[data-field="${this.sortColumn}"] i`);
        if (sortedHeader) {
            sortedHeader.className = this.sortOrder === 'asc' 
                ? 'bi bi-arrow-up ms-1' 
                : 'bi bi-arrow-down ms-1';
        }
    }
    
    async loadData() {
        try {
            const params = new URLSearchParams({
                search: this.searchTerm,
                offset: (this.currentPage - 1) * this.options.pageSize,
                limit: this.options.pageSize,
                sort: this.sortColumn,
                order: this.sortOrder
            });
            
            const url = this.options.ajax && this.options.ajax.url ? this.options.ajax.url : this.options.searchUrl || '';
            const fullUrl = `${url}?${params}`;
            console.log('📡 Fetching data from:', fullUrl);
            
            const response = await fetch(fullUrl);
            console.log('📨 Response status:', response.status, response.statusText);
            console.log('📨 Response headers:', Object.fromEntries(response.headers.entries()));
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ HTTP error response:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const responseText = await response.text();
            console.log('📄 Raw response:', responseText.substring(0, 500));
            
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('📦 Parsed JSON data:', data);
                console.log('📊 Total records:', data.total);
                console.log('📊 Rows count:', data.rows ? data.rows.length : 0);
            } catch (parseError) {
                console.error('❌ JSON parse error:', parseError);
                console.error('Response text:', responseText);
                throw new Error('Failed to parse JSON response');
            }
            
            this.totalRecords = data.total || 0;
            this.renderRows(data.rows || []);
            this.updatePagination();
            this.updateInfo();
            
            if (this.options.onLoadComplete) {
                this.options.onLoadComplete(data);
            }
            
            console.log(`✅ Loaded ${data.rows?.length || 0} records`);
        } catch (error) {
            console.error('❌ Failed to load data:', error);
            this.showError('Failed to load data. Please try again.');
        }
    }
    
    renderRows(rows) {
        console.log('🖌️ Rendering rows...', rows.length, 'rows');
        const tbody = document.getElementById(`${this.tableId}-body`);
        console.log('tbody element:', tbody);
        
        if (rows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${this.options.columns.length}" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox display-1"></i>
                        <p class="mt-3">No records found</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = rows.map(row => {
            const rowId = row[this.options.uniqueId];
            return `
                <tr data-id="${rowId}" class="table-row">
                    ${this.options.columns.map(col => {
                        let value = row[col.field];
                        
                        // Apply formatter or render function if exists
                        if (col.render) {
                            value = col.render(value, row);
                        } else if (col.formatter) {
                            value = col.formatter(value, row);
                        } else if (col.type === 'currency') {
                            // Format as currency
                            value = this.formatCurrency(value);
                        }
                        
                        return `<td>${value !== null && value !== undefined ? value : ''}</td>`;
                    }).join('')}
                </tr>
            `;
        }).join('');
        
        // Attach row click events
        tbody.querySelectorAll('tr.table-row').forEach(tr => {
            tr.style.cursor = 'pointer';
            tr.addEventListener('click', (e) => {
                if (!e.target.closest('button, a')) {
                    const rowId = tr.dataset.id;
                    const rowData = rows.find(r => r[this.options.uniqueId] == rowId);
                    if (this.options.onRowClick) {
                        this.options.onRowClick(rowData);
                    }
                }
            });
        });
        
        // Attach action button click events
        tbody.querySelectorAll('button.action-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent row click
                const actionName = btn.dataset.action;
                const rowId = btn.dataset.rowId;
                const rowData = rows.find(r => {
                    return r.person_id == rowId || r.item_id == rowId || r.id == rowId || r[Object.keys(r)[0]] == rowId;
                });
                
                // Call the action function if it exists in global scope
                if (typeof window[actionName] === 'function') {
                    window[actionName](rowData);
                } else {
                    console.error(`Action function '${actionName}' not found`);
                }
            });
        });
    }
    
    updatePagination() {
        const totalPages = Math.ceil(this.totalRecords / this.options.pageSize);
        const pagination = document.getElementById(`${this.tableId}-pagination`);
        
        if (totalPages <= 1) {
            pagination.innerHTML = '';
            return;
        }
        
        let html = '';
        
        // Previous
        html += `
            <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${this.currentPage - 1}">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        `;
        
        // Pages
        const startPage = Math.max(1, this.currentPage - 2);
        const endPage = Math.min(totalPages, this.currentPage + 2);
        
        if (startPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
        }
        
        // Next
        html += `
            <li class="page-item ${this.currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${this.currentPage + 1}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        `;
        
        pagination.innerHTML = html;
        
        // Attach click events
        pagination.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(link.dataset.page);
                if (page && page !== this.currentPage) {
                    this.currentPage = page;
                    this.loadData();
                }
            });
        });
    }
    
    updateInfo() {
        const info = document.getElementById(`${this.tableId}-info`);
        const start = (this.currentPage - 1) * this.options.pageSize + 1;
        const end = Math.min(this.currentPage * this.options.pageSize, this.totalRecords);
        
        info.textContent = this.totalRecords > 0 
            ? `Showing ${start} to ${end} of ${this.totalRecords} records`
            : 'No records found';
    }
    
    refresh() {
        console.log('Refreshing datatable...');
        this.loadData();
    }
    
    exportData() {
        // Simple CSV export
        const rows = Array.from(document.querySelectorAll(`#${this.tableId}-body tr`));
        const headers = this.options.columns.map(col => col.title).join(',');
        
        let csv = headers + '\n';
        rows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'));
            csv += cells.map(cell => `"${cell.textContent.trim()}"`).join(',') + '\n';
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `export-${Date.now()}.csv`;
        a.click();
        
        showNotification('Data exported successfully', 'success');
    }
    
    showError(message) {
        const tbody = document.getElementById(`${this.tableId}-body`);
        tbody.innerHTML = `
            <tr>
                <td colspan="${this.options.columns.length}" class="text-center py-5 text-danger">
                    <i class="bi bi-exclamation-triangle display-1"></i>
                    <p class="mt-3">${message}</p>
                </td>
            </tr>
        `;
    }
    
    renderActions(row) {
        if (!this.options.actions || this.options.actions.length === 0) {
            return '';
        }
        
        const rowId = row.person_id || row.item_id || row.id || row[Object.keys(row)[0]];
        
        const buttons = this.options.actions.map((action, index) => {
            const btnClass = action.className || 'btn-outline';
            const icon = action.icon || '';
            const title = action.title || '';
            
            return `
                <button type="button" 
                        class="btn btn-sm ${btnClass} action-btn" 
                        data-action="${action.onClick}" 
                        data-row-id="${rowId}"
                        data-action-index="${index}"
                        title="${title}"
                        style="margin-right: 4px;">
                    ${icon}
                </button>
            `;
        }).join('');
        
        return `<div style="display: flex; gap: 4px; justify-content: flex-start;">${buttons}</div>`;
    }
    
    formatCurrency(value) {
        if (value === null || value === undefined || value === '') {
            return '$0.00';
        }
        
        const num = parseFloat(value);
        if (isNaN(num)) {
            return '$0.00';
        }
        
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(num);
    }
}

// Make it globally available
window.ModernDataTable = ModernDataTable;

console.log('✅ ModernDataTable loaded');
