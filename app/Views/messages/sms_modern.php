<?php
/**
 * MODERN SMS SENDING - Bootstrap 5
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Messages.sms_send'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Content -->
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots me-2"></i>
                        <?= lang('Messages.sms_send') ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?= form_open("messages/send", [
                        'id' => 'send_sms_form',
                        'method' => 'post'
                    ]) ?>
                    
                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">
                            <i class="bi bi-telephone me-1"></i>
                            <?= lang('Messages.phone') ?>
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-lg" 
                            id="phone"
                            name="phone" 
                            placeholder="<?= lang('Messages.phone_placeholder') ?>"
                            required>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            <?= lang('Messages.multiple_phones') ?>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold">
                            <i class="bi bi-chat-text me-1"></i>
                            <?= lang('Messages.message') ?>
                        </label>
                        <textarea 
                            class="form-control" 
                            id="message"
                            name="message" 
                            rows="5" 
                            placeholder="<?= lang('Messages.message_placeholder') ?>"
                            required></textarea>
                        <div class="form-text">
                            Character count: <span id="char-count">0</span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Clear
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit_btn">
                            <i class="bi bi-send me-1"></i>
                            Send SMS
                        </button>
                    </div>
                    
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info mt-3" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Note:</strong> SMS will be sent using the configured SMS gateway. Make sure your SMS service is properly configured.
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('📱 Modern SMS Page Ready');
    
    const form = document.getElementById('send_sms_form');
    const messageField = document.getElementById('message');
    const charCount = document.getElementById('char-count');
    const submitBtn = document.getElementById('submit_btn');
    
    // Character counter
    messageField.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
    
    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const phone = formData.get('phone');
        const message = formData.get('message');
        
        if (!phone || !message) {
            showNotification('Please fill in all fields', 'error');
            return;
        }
        
        // Disable button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Sending...';
        
        try {
            const response = await fetch('<?= base_url('messages/send') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message || 'SMS sent successfully!', 'success');
                form.reset();
                charCount.textContent = '0';
            } else {
                showNotification(data.message || 'Failed to send SMS', 'error');
            }
        } catch (error) {
            console.error('Send error:', error);
            showNotification('An error occurred while sending SMS', 'error');
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-send me-1"></i> Send SMS';
        }
    });
    
    console.log('✅ SMS Form Initialized');
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
