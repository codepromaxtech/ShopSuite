<?php
/**
 * MODERN GIFTCARD FORM - Bootstrap 5
 * Complete redesign with modern UI
 */
?>

<style>
.modern-form-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}
.modern-form-section h6 {
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-label-modern {
    font-size: 0.85rem;
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
}
.form-control-modern {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
}
.giftcard-preview {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 1rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.giftcard-preview h3 {
    font-size: 2rem;
    margin: 0;
}
.giftcard-preview small {
    opacity: 0.9;
}
</style>

<div class="container-fluid p-3">
    <!-- Alert Messages -->
    <div id="required_fields_message" class="alert alert-info alert-sm mb-3" style="font-size: 0.85rem;">
        <i class="bi bi-info-circle me-2"></i><?= lang('Common.fields_required_message') ?>
    </div>
    
    <ul id="error_message_box" class="error_message_box"></ul>

    <?= form_open("giftcards/save/$giftcard_id", ['id' => 'giftcard_form', 'class' => 'needs-validation', 'novalidate' => true]) ?>

    <!-- Giftcard Preview -->
    <div class="giftcard-preview">
        <i class="bi bi-gift display-1"></i>
        <h3 class="mt-3 mb-0" id="preview_amount"><?= $config['currency_symbol'] ?>0.00</h3>
        <small id="preview_number">Card Number: <span>Not Set</span></small>
    </div>

    <!-- Giftcard Details -->
    <div class="modern-form-section">
        <h6><i class="bi bi-credit-card me-2"></i>Giftcard Details</h6>
        <div class="row g-3">
            <!-- Giftcard Number -->
            <div class="col-md-6">
                <label for="giftcard_number" class="form-label form-label-modern">
                    <?= lang('Giftcards.giftcard_number') ?>
                    <?php if ($config['giftcard_number'] == 'series'): ?>
                    <span class="text-danger">*</span>
                    <?php endif; ?>
                </label>
                <?= form_input([
                    'name' => 'giftcard_number',
                    'id' => 'giftcard_number',
                    'class' => 'form-control form-control-modern',
                    'value' => $giftcard_number ?? '',
                    'required' => $config['giftcard_number'] == 'series',
                    'placeholder' => 'e.g., GC-12345'
                ]) ?>
                <small class="form-text text-muted">
                    <?php if ($config['giftcard_number'] == 'series'): ?>
                    Enter a unique giftcard number
                    <?php else: ?>
                    Leave blank to auto-generate
                    <?php endif; ?>
                </small>
                <div class="invalid-feedback">Giftcard number is required</div>
            </div>

            <!-- Giftcard Value -->
            <div class="col-md-6">
                <label for="giftcard_amount" class="form-label form-label-modern">
                    <?= lang('Giftcards.card_value') ?> <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <?php if (!is_right_side_currency_symbol()): ?>
                    <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                    <?php endif; ?>
                    
                    <?= form_input([
                        'name' => 'giftcard_amount',
                        'id' => 'giftcard_amount',
                        'class' => 'form-control form-control-modern',
                        'type' => 'number',
                        'step' => '0.01',
                        'min' => '0.01',
                        'value' => to_currency_no_money($giftcard_value ?? 0),
                        'required' => true,
                        'placeholder' => '0.00'
                    ]) ?>
                    
                    <?php if (is_right_side_currency_symbol()): ?>
                    <span class="input-group-text"><?= esc($config['currency_symbol']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="invalid-feedback">Giftcard value is required</div>
            </div>
        </div>
    </div>

    <!-- Customer Assignment -->
    <div class="modern-form-section">
        <h6><i class="bi bi-person me-2"></i>Assign to Customer (Optional)</h6>
        <div class="row g-3">
            <div class="col-12">
                <label for="person_name" class="form-label form-label-modern">
                    <?= lang('Giftcards.person_id') ?>
                </label>
                <div class="input-group">
                    <?= form_input([
                        'name' => 'person_name',
                        'id' => 'person_name',
                        'class' => 'form-control form-control-modern',
                        'value' => $selected_person_name ?? '',
                        'placeholder' => 'Type customer name to search...',
                        'autocomplete' => 'off'
                    ]) ?>
                    <button class="btn btn-outline-secondary" type="button" id="clear_customer">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
                <?= form_hidden('person_id', (string)($selected_person_id ?? '')) ?>
                <small class="form-text text-muted">
                    Start typing to search for a customer. Leave blank for unassigned giftcard.
                </small>
            </div>
        </div>
    </div>

    <?= form_close() ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    console.log('✅ Modern Giftcard Form Loaded');
    
    // Connect modal submit button to form
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    if (modalSubmitBtn) {
        modalSubmitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Save Giftcard';
        modalSubmitBtn.addEventListener('click', function() {
            document.getElementById('giftcard_form').dispatchEvent(new Event('submit'));
        });
    }

    // Update preview
    function updatePreview() {
        const amount = $('#giftcard_amount').val() || '0.00';
        const number = $('#giftcard_number').val() || 'Not Set';
        const symbol = '<?= esc($config['currency_symbol']) ?>';
        
        $('#preview_amount').text(symbol + parseFloat(amount).toFixed(2));
        $('#preview_number span').text(number);
    }

    $('#giftcard_amount, #giftcard_number').on('input', updatePreview);
    updatePreview();

    // Clear customer button
    $('#clear_customer').click(function() {
        $('#person_name').val('');
        $('#person_id').val('');
    });

    // Customer autocomplete
    $("input[name='person_name']").change(function() {
        !$(this).val() && $(this).val('');
    });

    var fill_value = function(event, ui) {
        event.preventDefault();
        $(this).val((ui.item ? ui.item.label : ""));
        $("input[name='person_id']").val(ui.item.value);
        $("input[name='person_name']").val(ui.item.label);
    };

    $('#person_name').autocomplete({
        source: "<?= esc("customers/suggest") ?>",
        minChars: 0,
        delay: 15,
        change: fill_value,
        cacheLength: 1,
        appendTo: '.container-fluid',
        select: fill_value,
        focus: fill_value
    });

    // Native HTML5 form validation and submission
    const form = document.getElementById('giftcard_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return false;
        }
        
        const submitBtn = document.getElementById('modal-submit-btn');
        const originalText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Saving...';
        }
        
        const formData = new FormData(form);
        
        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message || 'Giftcard saved successfully', 'success');
                    if (typeof window.giftcardsTable !== 'undefined' && window.giftcardsTable.refresh) {
                        window.giftcardsTable.refresh();
                    }
                    if (typeof hideModal === 'function') {
                        setTimeout(() => hideModal(), 500);
                    } else if (typeof closeModal === 'function') {
                        setTimeout(() => closeModal(), 500);
                    }
                } else {
                    showNotification(response.message || 'Failed to save giftcard', 'error');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Save error:', error);
                showNotification('An error occurred while saving', 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
        
        return false;
    });
});
</script>
