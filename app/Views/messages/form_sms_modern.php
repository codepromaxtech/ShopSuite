<?php
/**
 * MODERN SMS MESSAGE FORM - Send SMS to Person
 * @var object $person_info
 * @var array $config
 */

$title = 'Send SMS Message - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            <div>
                <h1>Send SMS Message</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button type="button" class="btn btn-outline" onclick="window.history.back()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('messages') ?>">Messages</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Send SMS</div>
    </div>
</div>

<?= form_open("messages/send_form/{$person_info->person_id}", ['id' => 'send_sms_form', 'class' => 'form-modern']) ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <!-- Message Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-header-title">Message Details</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="first_name" 
                           name="first_name" 
                           value="<?= esc($person_info->first_name) ?>"
                           readonly>
                </div>
                
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="last_name" 
                           name="last_name" 
                           value="<?= esc($person_info->last_name) ?>"
                           readonly>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label form-label-required">Phone Number</label>
                    <div class="u-position-relative">
                        <svg class="u-position-absolute_left-12px_top-50pct" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <input type="tel" 
                               class="form-control" 
                               id="phone" 
                               name="phone" 
                               value="<?= esc($person_info->phone_number) ?>"
                               style="padding-left: 40px;"
                               placeholder="+1234567890"
                               required>
                    </div>
                    <small class="form-text">Include country code for international numbers</small>
                </div>
                
                <div class="form-group">
                    <label for="message" class="form-label form-label-required">Message</label>
                    <textarea class="form-control" 
                              id="message" 
                              name="message" 
                              rows="6"
                              placeholder="Type your message here..."
                              required><?= esc($config['msg_msg'] ?? '') ?></textarea>
                    <div class="u-display-flex_justify-content-space-bet-1">
                        <small class="form-text">Maximum 160 characters per SMS</small>
                        <small class="form-text" id="char_count">0 / 160</small>
                    </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Send Message
                </button>
                
                <button type="button" class="btn btn-outline btn-block u-margin-top-space-3" onclick="window.history.back()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </button>
            </div>
        </div>
        
        <!-- SMS Info -->
        <div class="card u-margin-top-space-6">
            <div class="card-header">
                <h3 class="card-header-title">SMS Information</h3>
            </div>
            <div class="card-body">
                <div class="u-font-size-text-sm_color-text-secondary">
                    <div class="u-display-flex_align-items-start_gap-spa">
                        <svg class="u-flex-shrink-0_margin-top-2px" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <strong>Standard SMS:</strong> 160 characters max per message
                        </div>
                    </div>
                    <div class="u-display-flex_align-items-start_gap-spa">
                        <svg class="u-flex-shrink-0_margin-top-2px" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            Messages are sent immediately
                        </div>
                    </div>
                    <div class="u-display-flex_align-items-start_gap-spa-1">
                        <svg class="u-flex-shrink-0_margin-top-2px" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0121 12c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2c1.836 0 3.551.463 5.058 1.281"></path>
                        </svg>
                        <div>
                            Make sure the phone number is correct
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<script>
// Character counter
const messageTextarea = document.getElementById('message');
const charCount = document.getElementById('char_count');

messageTextarea.addEventListener('input', function() {
    const length = this.value.length;
    charCount.textContent = `${length} / 160`;
    
    if (length > 160) {
        charCount.style.color = 'var(--error-600)';
    } else if (length > 140) {
        charCount.style.color = 'var(--warning-600)';
    } else {
        charCount.style.color = 'var(--text-secondary)';
    }
});

// Initialize character count
messageTextarea.dispatchEvent(new Event('input'));

// Form validation
document.getElementById('send_sms_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('phone').value.trim();
    const message = document.getElementById('message').value.trim();
    
    // Validate phone number
    if (!phone) {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.showToast('Error', 'Phone number is required', 'error');
        }
        return;
    }
    
    // Validate message
    if (!message) {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.showToast('Error', 'Message is required', 'error');
        }
        return;
    }
    
    if (message.length > 160) {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.showToast('Warning', 'Message exceeds 160 characters and may be split into multiple SMS', 'warning');
        }
    }
    
    // Confirm before sending
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showConfirm(
            'Send SMS',
            `Send message to ${phone}?`,
            () => {
                sendSMS();
            }
        );
    } else {
        if (confirm(`Send message to ${phone}?`)) {
            sendSMS();
        }
    }
});

function sendSMS() {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showLoading('Sending SMS...');
    }
    
    const form = document.getElementById('send_sms_form');
    const formData = new FormData(form);
    
    fetch(form.action, {
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
                window.shopsuiteApp.showToast('Success', data.message || 'SMS sent successfully', 'success');
            }
            setTimeout(() => {
                window.history.back();
            }, 1500);
        } else {
            if (window.shopsuiteApp) {
                window.shopsuiteApp.showToast('Error', data.message || 'Failed to send SMS', 'error');
            }
        }
    })
    .catch(error => {
        if (window.shopsuiteApp) {
            window.shopsuiteApp.hideLoading();
            window.shopsuiteApp.showToast('Error', 'An error occurred while sending SMS', 'error');
        }
        console.error('Error:', error);
    });
}
</script>

<?php echo view('layouts/modern_footer'); ?>
