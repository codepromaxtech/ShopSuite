<?php
/**
 * USER SETTINGS PAGE
 * Personal information, password, and preferences
 * @var object $user_info
 * @var array $config
 */
?>

$title = 'My Settings';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="container-fluid">
    <div class="row">
        <!-- Settings Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-person-gear me-2"></i>Settings
                    </h5>
                    <div class="list-group list-group-flush">
                        <a href="#personal" class="list-group-item list-group-item-action active" data-tab="personal">
                            <i class="bi bi-person-circle me-2"></i> Personal Info
                        </a>
                        <a href="#password" class="list-group-item list-group-item-action" data-tab="password">
                            <i class="bi bi-key me-2"></i> Change Password
                        </a>
                        <a href="#preferences" class="list-group-item list-group-item-action" data-tab="preferences">
                            <i class="bi bi-palette me-2"></i> Preferences
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-lg-9">
            <!-- Personal Information -->
            <div class="card border-0 shadow-sm mb-4 settings-panel" id="personal">
                <div class="card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <form id="personalInfoForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="<?= esc($user_info->first_name ?? '') ?>" disabled>
                                <small class="text-secondary">Contact administrator to change</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="<?= esc($user_info->last_name ?? '') ?>" disabled>
                                <small class="text-secondary">Contact administrator to change</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="<?= esc($user_info->username ?? '') ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= esc($user_info->email ?? '') ?>" disabled>
                                <small class="text-secondary">Contact administrator to change</small>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    To update your personal information, please contact your system administrator or visit 
                                    <a href="<?= base_url('employees/view/' . ($user_info->person_id ?? '')) ?>">My Profile</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card border-0 shadow-sm mb-4 settings-panel d-none" id="password">
                <div class="card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="bi bi-key me-2"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm" action="<?= base_url('home/save_password') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="person_id" value="<?= $user_info->person_id ?? '' ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Current Password *</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password *</label>
                                <input type="password" class="form-control" name="password" id="new_password" required minlength="8">
                                <small class="text-secondary">Minimum 8 characters</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password *</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preferences -->
            <div class="card border-0 shadow-sm mb-4 settings-panel d-none" id="preferences">
                <div class="card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="bi bi-palette me-2"></i>Preferences
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Appearance</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Theme</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="theme" id="theme-light" value="light" autocomplete="off">
                                <label class="btn btn-outline-primary" for="theme-light">
                                    <i class="bi bi-sun me-1"></i>Light
                                </label>
                                
                                <input type="radio" class="btn-check" name="theme" id="theme-dark" value="dark" autocomplete="off">
                                <label class="btn btn-outline-primary" for="theme-dark">
                                    <i class="bi bi-moon-stars me-1"></i>Dark
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-success d-none" id="theme-success">
                                <i class="bi bi-check-circle me-2"></i>Theme updated successfully!
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Preview</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Sample Card</h6>
                                    <p class="card-text">This is how your interface will look with the selected theme.</p>
                                    <button class="btn btn-primary btn-sm">Sample Button</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('⚙️ User Settings Page Loaded');
    
    // Tab Switching
    const tabs = document.querySelectorAll('[data-tab]');
    const panels = document.querySelectorAll('.settings-panel');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetTab = this.getAttribute('data-tab');
            
            // Update active states
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show target panel
            panels.forEach(panel => {
                if (panel.id === targetTab) {
                    panel.style.display = 'block';
                } else {
                    panel.style.display = 'none';
                }
            });
        });
    });
    
    // Load current theme
    const savedTheme = localStorage.getItem('theme') || 'dark';
    document.getElementById('theme-' + savedTheme).checked = true;
    
    // Theme change handler
    const themeInputs = document.querySelectorAll('input[name="theme"]');
    themeInputs.forEach(input => {
        input.addEventListener('change', function() {
            const newTheme = this.value;
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Show success message
            const successAlert = document.getElementById('theme-success');
            successAlert.classList.remove('d-none');
            setTimeout(() => {
                successAlert.classList.add('d-none');
            }, 3000);
        });
    });
    
    // Password form validation
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                showNotification('Passwords do not match', 'error');
                return;
            }
            
            // Submit form via AJAX
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message || 'Password updated successfully', 'success');
                    passwordForm.reset();
                } else {
                    showNotification(data.message || 'Failed to update password', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred', 'error');
            });
        });
    }
});
</script>

<?= view('layouts/modern_footer') ?>
