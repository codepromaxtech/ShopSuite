<?php
/**
 * POST + CSRF email sender for sale documents.
 *
 * @var string $post_url
 * @var string $button_label
 * @var string $button_sent_label
 * @var bool $auto_send
 */
?>
<script>
function sendEmail() {
    const btn = document.getElementById('email_button');
    if (!btn) {
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Sending...';

    window.shopsuiteApp.postAction(<?= json_encode($post_url) ?>)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sent!';
                btn.classList.add('btn-email-sent');
                btn.classList.remove('btn-email-default');
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = <?= json_encode($button_label) ?>;
                    btn.classList.remove('btn-email-sent');
                    btn.classList.add('btn-email-default');
                }, 3000);
            } else {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Failed';
                btn.disabled = false;
                if (data.message && window.shopsuiteApp) {
                    window.shopsuiteApp.showToast('Email Failed', data.message, 'error');
                }
            }
        })
        .catch(() => {
            btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Error';
            btn.disabled = false;
        });
}

<?php if (!empty($auto_send)): ?>
sendEmail();
<?php endif; ?>
</script>
