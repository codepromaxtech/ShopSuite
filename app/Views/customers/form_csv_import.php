<!-- Modern CSV Import with Drag & Drop and Preview -->
<div class="container-fluid">
    <ul id="error_message_box" class="error_message_box"></ul>
    
    <!-- Template Download -->
    <div class="alert alert-info d-flex align-items-center mb-4">
        <i class="bi bi-info-circle me-3 fs-4"></i>
        <div class="flex-grow-1">
            <strong>Need a template?</strong> Download our CSV template to see the required format.
        </div>
        <a href="<?= esc('customers/csv') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-download me-1"></i><?= lang('Common.download_import_template') ?>
        </a>
    </div>
    
    <?= form_open_multipart('customers/importCsvFile/', ['id' => 'csv_form']) ?>
        <!-- Drag & Drop Zone -->
        <div class="drop-zone" id="drop-zone">
            <div class="drop-zone-icon">
                <i class="bi bi-cloud-arrow-up"></i>
            </div>
            <div class="drop-zone-text">
                Drag & Drop your CSV file here
            </div>
            <div class="drop-zone-hint">
                or click to browse
            </div>
            <input type="file" id="file_path" name="file_path" accept=".csv" style="display: none;">
        </div>
        
        <!-- CSV Preview Container -->
        <div id="preview-container" style="display: none;"></div>
        
        <!-- Import Options -->
        <div id="import-options" style="display: none;" class="mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-gear me-2"></i>Import Options
                    </h6>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="skip_first_row" name="skip_first_row" checked>
                                <label class="form-check-label" for="skip_first_row">
                                    Skip first row (headers)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing">
                                <label class="form-check-label" for="update_existing">
                                    Update existing customers
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>

<script type="text/javascript">
    let selectedFile = null;
    
    $(document).ready(function() {
        // Initialize file uploader
        const uploader = new FileUploader({
            dropZone: '#drop-zone',
            fileInput: '#file_path',
            previewContainer: '#preview-container',
            maxFileSize: 10 * 1024 * 1024, // 10MB
            allowedTypes: ['text/csv', 'application/vnd.ms-excel'],
            onFileSelect: function(file) {
                selectedFile = file;
                $('#import-options').slideDown();
            }
        });
        
        // Validation and submit handling
        $('#csv_form').validate($.extend({
            submitHandler: function(form) {
                if (!selectedFile) {
                    showNotification('Please select a CSV file', 'error');
                    return false;
                }
                
                // Show loading
                showLoading('Importing customers...');
                
                // Create FormData for AJAX upload
                const formData = new FormData(form);
                
                $.ajax({
                    url: '<?= base_url('customers/importCsvFile') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        hideLoading();
                        
                        if (response.success) {
                            showNotification(
                                response.message || 'Customers imported successfully!',
                                'success'
                            );
                            
                            // Close dialog
                            dialog_support.hide();
                            
                            // Refresh table
                            $('#table').bootstrapTable('refresh');
                        } else {
                            showNotification(
                                response.message || 'Import failed',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        showNotification('Import failed: ' + error, 'error');
                    }
                });
                
                return false; // Prevent default form submission
            },
            
            errorLabelContainer: '#error_message_box',
            
            rules: {
                file_path: 'required'
            },
            
            messages: {
                file_path: "<?= lang('Common.import_full_path') ?>"
            }
        }, form_support.error));
    });
</script>
