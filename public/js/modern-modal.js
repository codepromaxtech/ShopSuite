/**
 * Modern Modal System
 * Pure Bootstrap 5 - No BootstrapDialog dependency
 * Handles dynamic content loading and form submissions
 */

class ModernModal {
    constructor() {
        this.modalElement = null;
        this.modalInstance = null;
        this.currentForm = null;
    }
    
    /**
     * Open a modal with AJAX-loaded content
     */
    async open(url, title = 'Form', options = {}) {
        const {
            size = 'lg', // sm, lg, xl, or empty for default
            buttons = null,
            onShow = null,
            onHide = null,
            onSubmit = null
        } = options;
        
        // Show loading
        if (typeof showLoading === 'function') {
            showLoading('Loading...');
        }
        
        try {
            // Load content via AJAX
            console.log('🔄 Loading modal content from:', url);
            const content = await $.get(url);
            console.log('✅ Content loaded, length:', content.length);
            
            if (typeof hideLoading === 'function') {
                hideLoading();
            }
            
            // Check if content is empty
            if (!content || content.trim().length === 0) {
                throw new Error('Empty content received from server');
            }
            
            // Create modal HTML
            const modalId = 'dynamicModal_' + Date.now();
            const modalHtml = `
                <div class="modal fade" id="${modalId}" tabindex="-1" data-bs-backdrop="static">
                    <div class="modal-dialog modal-${size} modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${content}
                            </div>
                            <div class="modal-footer">
                                ${this.renderButtons(buttons)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove any existing modals with same ID
            $(`#${modalId}`).remove();
            
            // Add to DOM
            $('body').append(modalHtml);
            this.modalElement = document.getElementById(modalId);
            
            // Initialize Bootstrap Modal
            this.modalInstance = new bootstrap.Modal(this.modalElement, {
                backdrop: 'static',
                keyboard: true
            });
            
            // Find form in modal
            this.currentForm = this.modalElement.querySelector('form');
            console.log('📋 Form found:', this.currentForm ? 'Yes' : 'No');
            
            if (this.currentForm) {
                const inputs = this.currentForm.querySelectorAll('input, textarea, select');
                console.log('📝 Form fields found:', inputs.length);
                inputs.forEach((input, i) => {
                    console.log(`  Field ${i + 1}: ${input.type || input.tagName} - ${input.name || input.id}`);
                });
            }
            
            // Execute any scripts in the loaded content
            this.executeScripts(this.modalElement);
            
            // Set up event listeners
            this.setupEventListeners(onShow, onHide, onSubmit);
            
            // Initialize form validation if jQuery Validation is available
            if (this.currentForm && $.fn.validate) {
                this.initializeFormValidation();
            }
            
            // Show modal
            this.modalInstance.show();
            
            console.log('✅ Modal opened successfully');
            
        } catch (error) {
            if (typeof hideLoading === 'function') {
                hideLoading();
            }
            console.error('Failed to load modal content:', error);
            if (typeof showNotification === 'function') {
                showNotification('Failed to load form', 'error');
            }
        }
    }
    
    /**
     * Execute scripts in loaded content
     */
    executeScripts(container) {
        const scripts = container.querySelectorAll('script');
        console.log('📦 Found', scripts.length, 'scripts to execute');
        
        scripts.forEach((oldScript, index) => {
            const newScript = document.createElement('script');
            
            // Copy attributes
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            // Copy content
            newScript.textContent = oldScript.textContent;
            
            // Replace old script with new one (this executes it)
            oldScript.parentNode.replaceChild(newScript, oldScript);
            
            console.log('✅ Executed script', index + 1);
        });
    }
    
    /**
     * Render modal buttons
     */
    renderButtons(buttons) {
        if (!buttons) {
            // Default buttons
            return `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="modal-submit-btn">
                    <i class="bi bi-check-circle me-1"></i>Submit
                </button>
            `;
        }
        
        // Custom buttons
        return buttons.map(btn => {
            const btnClass = btn.className || 'btn-primary';
            const btnId = btn.id || '';
            const btnIcon = btn.icon || '';
            return `
                <button type="button" class="btn ${btnClass}" id="${btnId}" ${btn.dismiss ? 'data-bs-dismiss="modal"' : ''}>
                    ${btnIcon ? `<i class="${btnIcon} me-1"></i>` : ''}${btn.label}
                </button>
            `;
        }).join('');
    }
    
    /**
     * Set up event listeners
     */
    setupEventListeners(onShow, onHide, onSubmit) {
        // On shown
        this.modalElement.addEventListener('shown.bs.modal', () => {
            // Focus first input
            const firstInput = this.modalElement.querySelector('input:not([type="hidden"]), textarea, select');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
            
            if (onShow) onShow(this);
        });
        
        // On hidden
        this.modalElement.addEventListener('hidden.bs.modal', () => {
            if (onHide) onHide(this);
            // Clean up - remove modal from DOM
            setTimeout(() => {
                this.modalElement.remove();
                this.modalElement = null;
                this.modalInstance = null;
                this.currentForm = null;
            }, 300);
        });
        
        // Submit button click
        const submitBtn = this.modalElement.querySelector('#modal-submit-btn');
        if (submitBtn) {
            submitBtn.addEventListener('click', () => {
                if (this.currentForm) {
                    if (onSubmit) {
                        onSubmit(this.currentForm, this);
                    } else {
                        this.submitForm();
                    }
                }
            });
        }
        
        // Form submit via Enter key
        if (this.currentForm) {
            this.currentForm.addEventListener('submit', (e) => {
                e.preventDefault();
                if (onSubmit) {
                    onSubmit(this.currentForm, this);
                } else {
                    this.submitForm();
                }
            });
        }
    }
    
    /**
     * Initialize form validation
     */
    initializeFormValidation() {
        if (!this.currentForm) return;
        
        const $form = $(this.currentForm);
        
        // Check if form already has validation rules
        const hasRules = $form.data('validator') !== undefined;
        
        if (!hasRules) {
            // Apply basic validation
            $form.validate({
                errorClass: 'is-invalid',
                validClass: 'is-valid',
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group, .mb-3').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                },
                submitHandler: () => {
                    this.submitForm();
                }
            });
        }
    }
    
    /**
     * Submit form via AJAX
     */
    async submitForm() {
        if (!this.currentForm) return;
        
        const $form = $(this.currentForm);
        const validator = $form.data('validator');
        
        // Validate
        if (validator && !$form.valid()) {
            return;
        }
        
        // Disable submit button
        const submitBtn = this.modalElement.querySelector('#modal-submit-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Submitting...';
        }
        
        // Prepare form data
        const formData = new FormData(this.currentForm);
        
        try {
            const response = await $.ajax({
                url: this.currentForm.action,
                method: this.currentForm.method || 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json'
            });
            
            // Handle response
            if (response.success) {
                // Close modal
                this.close();
                
                // Show notification
                if (typeof showNotification === 'function') {
                    showNotification(response.message || 'Saved successfully', 'success');
                }
                
                // Refresh table if ModernTableManager instance exists
                if (window.tableManager) {
                    window.tableManager.handleSubmit(response);
                }
                
                // Trigger custom event
                document.dispatchEvent(new CustomEvent('formSubmitSuccess', { 
                    detail: { response, form: this.currentForm }
                }));
                
            } else {
                // Show error
                if (typeof showNotification === 'function') {
                    showNotification(response.message || 'Save failed', 'error');
                }
                
                // Re-enable submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit';
                }
            }
            
        } catch (error) {
            console.error('Form submission error:', error);
            
            if (typeof showNotification === 'function') {
                showNotification('Failed to submit form', 'error');
            }
            
            // Re-enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit';
            }
        }
    }
    
    /**
     * Close the modal
     */
    close() {
        if (this.modalInstance) {
            this.modalInstance.hide();
        }
    }
}

// Global instance
window.modernModal = new ModernModal();

/**
 * Global helper function to open modal
 */
window.openModal = async function(url, title, options) {
    return await window.modernModal.open(url, title, options);
};

/**
 * Initialize modal triggers
 * Finds all elements with data-modal-url and sets up click handlers
 */
window.initializeModalTriggers = function(selector = '[data-modal-url]') {
    document.querySelectorAll(selector).forEach(element => {
        element.addEventListener('click', async function(e) {
            e.preventDefault();
            const url = this.dataset.modalUrl || this.getAttribute('href');
            const title = this.dataset.modalTitle || this.getAttribute('title') || 'Form';
            const size = this.dataset.modalSize || 'lg';
            
            await openModal(url, title, { size });
        });
    });
    
    // Also handle .modal-dlg class (for backward compatibility)
    document.querySelectorAll('.modal-dlg').forEach(element => {
        element.addEventListener('click', async function(e) {
            e.preventDefault();
            const url = this.dataset.href || this.getAttribute('href');
            const title = this.getAttribute('title') || 'Form';
            const size = this.dataset.modalSize || 'lg';
            
            if (url) {
                await openModal(url, title, { size });
            }
        });
    });
};

// Auto-initialize on document ready
document.addEventListener('DOMContentLoaded', () => {
    initializeModalTriggers();
});

// Reinitialize after AJAX content loads
document.addEventListener('ajaxComplete', () => {
    setTimeout(() => initializeModalTriggers(), 100);
});

console.log('✅ Modern Modal System loaded');
