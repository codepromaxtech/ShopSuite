/**
 * Modern File Upload with Drag & Drop
 * Supports CSV preview before import
 */

class FileUploader {
    constructor(options = {}) {
        this.dropZone = options.dropZone || '.drop-zone';
        this.fileInput = options.fileInput || '#file-input';
        this.previewContainer = options.previewContainer || '#preview-container';
        this.maxFileSize = options.maxFileSize || 5 * 1024 * 1024; // 5MB
        this.allowedTypes = options.allowedTypes || ['text/csv', 'application/vnd.ms-excel'];
        this.onFileSelect = options.onFileSelect || null;
        
        this.init();
    }
    
    init() {
        this.setupDropZone();
        this.setupFileInput();
    }
    
    setupDropZone() {
        const dropZones = document.querySelectorAll(this.dropZone);
        
        dropZones.forEach(zone => {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                zone.addEventListener(eventName, this.preventDefaults, false);
            });
            
            // Highlight drop zone when dragging over
            ['dragenter', 'dragover'].forEach(eventName => {
                zone.addEventListener(eventName, () => this.highlight(zone), false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                zone.addEventListener(eventName, () => this.unhighlight(zone), false);
            });
            
            // Handle dropped files
            zone.addEventListener('drop', (e) => this.handleDrop(e, zone), false);
            
            // Handle click to open file dialog
            zone.addEventListener('click', () => {
                document.querySelector(this.fileInput).click();
            });
        });
    }
    
    setupFileInput() {
        const input = document.querySelector(this.fileInput);
        if (input) {
            input.addEventListener('change', (e) => this.handleFiles(e.target.files));
        }
    }
    
    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    highlight(zone) {
        zone.classList.add('drop-zone-active');
    }
    
    unhighlight(zone) {
        zone.classList.remove('drop-zone-active');
    }
    
    handleDrop(e, zone) {
        const dt = e.dataTransfer;
        const files = dt.files;
        this.handleFiles(files);
    }
    
    handleFiles(files) {
        if (files.length === 0) return;
        
        const file = files[0];
        
        // Validate file
        if (!this.validateFile(file)) {
            return;
        }
        
        // Show preview if CSV
        if (file.type === 'text/csv' || file.name.endsWith('.csv')) {
            this.previewCSV(file);
        }
        
        // Call callback if provided
        if (this.onFileSelect) {
            this.onFileSelect(file);
        }
    }
    
    validateFile(file) {
        // Check file size
        if (file.size > this.maxFileSize) {
            showNotification(`File too large. Maximum size is ${this.maxFileSize / 1024 / 1024}MB`, 'error');
            return false;
        }
        
        // Check file type
        if (!this.allowedTypes.includes(file.type) && !file.name.endsWith('.csv')) {
            showNotification('Invalid file type. Please upload a CSV file.', 'error');
            return false;
        }
        
        return true;
    }
    
    async previewCSV(file) {
        const text = await file.text();
        const lines = text.split('\n').filter(line => line.trim());
        
        if (lines.length === 0) {
            showNotification('CSV file is empty', 'error');
            return;
        }
        
        // Parse CSV
        const headers = this.parseCSVLine(lines[0]);
        const rows = lines.slice(1, 11).map(line => this.parseCSVLine(line)); // Preview first 10 rows
        
        this.renderPreview(file, headers, rows, lines.length - 1);
    }
    
    parseCSVLine(line) {
        const result = [];
        let current = '';
        let inQuotes = false;
        
        for (let i = 0; i < line.length; i++) {
            const char = line[i];
            
            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === ',' && !inQuotes) {
                result.push(current.trim());
                current = '';
            } else {
                current += char;
            }
        }
        
        result.push(current.trim());
        return result;
    }
    
    renderPreview(file, headers, rows, totalRows) {
        const container = document.querySelector(this.previewContainer);
        if (!container) return;
        
        const html = `
            <div class="csv-preview fade-in">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>
                            ${file.name}
                        </h5>
                        <small class="text-muted">
                            ${(file.size / 1024).toFixed(2)} KB • ${totalRows} rows • ${headers.length} columns
                        </small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" onclick="clearPreview()">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Showing first 10 rows for preview. Click Import to process all ${totalRows} rows.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                ${headers.map(h => `<th>${h}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            ${rows.map(row => `
                                <tr>
                                    ${row.map(cell => `<td>${cell}</td>`).join('')}
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                
                ${totalRows > 10 ? `
                    <div class="text-muted small text-center mt-2">
                        ... and ${totalRows - 10} more rows
                    </div>
                ` : ''}
            </div>
        `;
        
        container.innerHTML = html;
        container.style.display = 'block';
        
        // Animate in
        setTimeout(() => {
            container.querySelector('.csv-preview').classList.add('show');
        }, 10);
    }
}

// Global function to clear preview
window.clearPreview = function() {
    const container = document.querySelector('#preview-container');
    if (container) {
        container.innerHTML = '';
        container.style.display = 'none';
    }
    
    // Reset file input
    const fileInput = document.querySelector('#file-input');
    if (fileInput) {
        fileInput.value = '';
    }
    
    showNotification('Preview cleared', 'info');
};

// Image uploader with preview
class ImageUploader extends FileUploader {
    constructor(options = {}) {
        super({
            ...options,
            allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            maxFileSize: 10 * 1024 * 1024 // 10MB for images
        });
    }
    
    handleFiles(files) {
        if (files.length === 0) return;
        
        Array.from(files).forEach(file => {
            if (!this.validateFile(file)) return;
            
            this.previewImage(file);
            
            if (this.onFileSelect) {
                this.onFileSelect(file);
            }
        });
    }
    
    previewImage(file) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            const container = document.querySelector(this.previewContainer);
            if (!container) return;
            
            const preview = document.createElement('div');
            preview.className = 'image-preview-item fade-in';
            preview.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <div class="image-preview-overlay">
                    <button class="btn btn-sm btn-danger" onclick="this.closest('.image-preview-item').remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="image-preview-name">${file.name}</div>
            `;
            
            container.appendChild(preview);
        };
        
        reader.readAsDataURL(file);
    }
}

// Bulk file uploader with progress
class BulkFileUploader {
    constructor(options = {}) {
        this.endpoint = options.endpoint;
        this.onProgress = options.onProgress || null;
        this.onComplete = options.onComplete || null;
        this.onError = options.onError || null;
    }
    
    async upload(files) {
        const formData = new FormData();
        
        Array.from(files).forEach((file, index) => {
            formData.append(`files[${index}]`, file);
        });
        
        try {
            const xhr = new XMLHttpRequest();
            
            // Track progress
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    if (this.onProgress) {
                        this.onProgress(percentComplete);
                    }
                }
            });
            
            // Handle completion
            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (this.onComplete) {
                        this.onComplete(response);
                    }
                } else {
                    if (this.onError) {
                        this.onError(new Error(`Upload failed: ${xhr.statusText}`));
                    }
                }
            });
            
            // Handle errors
            xhr.addEventListener('error', () => {
                if (this.onError) {
                    this.onError(new Error('Upload failed'));
                }
            });
            
            xhr.open('POST', this.endpoint);
            xhr.send(formData);
            
        } catch (error) {
            if (this.onError) {
                this.onError(error);
            }
        }
    }
}

console.log('✨ File Upload Module Loaded');
