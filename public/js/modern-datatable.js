/**
 * MODERN DATA TABLE - Pure ES6+ Solution
 * No external dependencies except Bootstrap 5 & jQuery (minimal)
 * Replaces Bootstrap Table library completely
 */

class ModernDataTable {
    constructor(options) {
        this.options = {
            tableId: options.tableId || 'dataTable',
            searchUrl: options.searchUrl || '',
            columns: options.columns || [],
            pageSize: options.pageSize || 20,
            uniqueId: options.uniqueId || 'id',
            onRowClick: options.onRowClick || null,
            onLoadComplete: options.onLoadComplete || null,
            actions: options.actions || []
        };
        
        this.currentPage = 1;
        this.totalRecords = 0;
        this.searchTerm = '';
        this.sortColumn = '';
        this.sortOrder = 'asc';
        this.selectedRows = new Set();
        
        this.init();
    }
    
    init() {
        console.log('✅ ModernDataTable initializing...');
        this.buildTable();
        this.attachEventListeners();
        this.loadData();
    }
    
    buildTable() {
        const container = document.getElementById(this.options.tableId + '-container');
        if (!container) {
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
                                <input type="text" class="form-control" id="${this.options.tableId}-search" 
                                       placeholder="Search...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <button class="btn btn-outline-primary" id="${this.options.tableId}-refresh">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                                <button class="btn btn-outline-success" id="${this.options.tableId}-export">
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
                    <table class="table table-hover table-striped mb-0" id="${this.options.tableId}">
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
                        <tbody id="${this.options.tableId}-body">
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
                            <div id="${this.options.tableId}-info" class="text-muted">
                                Loading...
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Table pagination">
                                <ul class="pagination pagination-sm justify-content-end mb-0" 
                                    id="${this.options.tableId}-pagination">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.innerHTML = html;
    }
    
    attachEventListeners() {
        // Search
        const searchInput = document.getElementById(`${this.options.tableId}-search`);
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
        const refreshBtn = document.getElementById(`${this.options.tableId}-refresh`);
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refresh());
        }
        
        // Export
        const exportBtn = document.getElementById(`${this.options.tableId}-export`);
        if (exportBtn) {
            exportBtn.addEventListener('click', () => this.exportData());
        }
        
        // Sort headers
        document.querySelectorAll(`#${this.options.tableId} th.sortable`).forEach(th => {
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
        document.querySelectorAll(`#${this.options.tableId} th.sortable i`).forEach(icon => {
            icon.className = 'bi bi-arrow-down-up ms-1';
        });
        
        const sortedHeader = document.querySelector(`#${this.options.tableId} th[data-field="${this.sortColumn}"] i`);
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
            
            const response = await fetch(`${this.options.searchUrl}?${params}`);
            const data = await response.json();
            
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
        const tbody = document.getElementById(`${this.options.tableId}-body`);
        
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
                        
                        // Apply formatter if exists
                        if (col.formatter) {
                            value = col.formatter(value, row);
                        }
                        
                        return `<td>${value || ''}</td>`;
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
    }
    
    updatePagination() {
        const totalPages = Math.ceil(this.totalRecords / this.options.pageSize);
        const pagination = document.getElementById(`${this.options.tableId}-pagination`);
        
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
        const info = document.getElementById(`${this.options.tableId}-info`);
        const start = (this.currentPage - 1) * this.options.pageSize + 1;
        const end = Math.min(this.currentPage * this.options.pageSize, this.totalRecords);
        
        info.textContent = this.totalRecords > 0 
            ? `Showing ${start} to ${end} of ${this.totalRecords} records`
            : 'No records found';
    }
    
    refresh() {
        showLoading('Refreshing...');
        this.loadData().finally(() => hideLoading());
    }
    
    exportData() {
        // Simple CSV export
        const rows = Array.from(document.querySelectorAll(`#${this.options.tableId}-body tr`));
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
        const tbody = document.getElementById(`${this.options.tableId}-body`);
        tbody.innerHTML = `
            <tr>
                <td colspan="${this.options.columns.length}" class="text-center py-5 text-danger">
                    <i class="bi bi-exclamation-triangle display-1"></i>
                    <p class="mt-3">${message}</p>
                </td>
            </tr>
        `;
    }
}

// Make it globally available
window.ModernDataTable = ModernDataTable;

console.log('✅ ModernDataTable loaded');
