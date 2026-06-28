<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0ea5e9">
    <title>Login - ShopSuite</title>
    
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/design-system.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/components.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/login-modern.min.css') ?>?v=1.1">
    
    
</head>
<body>
    <div class="split-login-wrapper">
        
        <!-- Left: Visual Side -->
        <div class="login-visual-side visual-container">
            
            <!-- Upgraded Abstract Graphics -->
            <div class="visual-bg-element orb-1"></div>
            <div class="visual-bg-element orb-2"></div>
            <div class="visual-bg-element orb-3"></div>
            
            <!-- Modern UI Elements Floating -->
            <div class="visual-card-1">
                <div class="visual-card-header">
                    <div class="mac-btn close-btn"></div>
                    <div class="mac-btn minimize-btn"></div>
                    <div class="mac-btn maximize-btn"></div>
                </div>
                <div class="visual-card-body-grid">
                    <div class="placeholder-bar mb-60"></div>
                    <div class="placeholder-bar mb-80"></div>
                    <div class="placeholder-box"></div>
                </div>
            </div>

            <div class="visual-card-2">
                <div class="visual-card-body-flex">
                    <div class="stat-icon-box">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="stat-title">+24% Sales</div>
                        <div class="stat-subtitle">This week</div>
                    </div>
                </div>
            </div>
            
            <div class="visual-content visual-hero-text">
                <h2>Unleash Your<br>Business Potential.</h2>
                <p>With ShopSuite, you manage inventory, point of sale, employees, and sales seamlessly. Innovate faster, manage effortlessly, and grow your enterprise locally and globally.</p>
            </div>
        </div>

        <!-- Right: Form Side -->
        <div class="login-form-side">
            <!-- Theme Toggle -->
            <button class="theme-toggle-login" data-action="toggle-theme" title="Toggle Theme">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>

            <div class="login-form-container">
                <a href="#" class="brand-logo">
                    <img src="<?= base_url('images/logo.png') ?>" alt="ShopSuite Logo" >
                    ShopSuite
                </a>

                <div class="login-header">
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to manage your enterprise operations.</p>
                </div>
                
                <?php if (isset($error_message) || session()->getFlashdata('error')): ?>
                    <div class="premium-alert" role="alert">
                        <svg class="u-flex-shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <strong>Authentication Failed</strong>
                            <div class="u-font-size-text-sm_margin-top-2px">
                                <?= isset($error_message) ? esc($error_message) : session()->getFlashdata('error') ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="premium-alert u-background-success-50_border-left-colo" role="alert">
                        <svg class="u-flex-shrink-0_color-success-500" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <strong>Success</strong>
                            <div class="u-font-size-text-sm_margin-top-2px"><?= session()->getFlashdata('success') ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($validation) && $validation->getErrors()): ?>
                    <div class="premium-alert" role="alert">
                        <svg class="u-flex-shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <strong>Validation Error</strong>
                            <div class="u-font-size-text-sm_margin-top-2px">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <div><?= esc($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('login') ?>" method="post" id="loginForm">
                    <?= csrf_field() ?>
                    
                    <div class="premium-form-group">
                        <input type="text" class="premium-input" id="username" name="username" placeholder=" " value="<?= esc($username ?? '') ?>" required autofocus autocomplete="username">
                        <label for="username" class="form-floating-label">Username</label>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    
                    <div class="premium-form-group">
                        <input type="password" class="premium-input" id="password" name="password" placeholder=" " required autocomplete="current-password">
                        <label for="password" class="form-floating-label">Password</label>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <div class="form-options premium-form-group" >
                        <label class="modern-checkbox" >
                            <input type="checkbox" name="remember" id="remember" >
                            <span>Keep me signed in</span>
                        </label>
                        <a href="#" class="auth-link" >Forgot Password?</a>
                    </div>
                    
                    <?php if (!empty($config['gcaptcha_enable'])): ?>
                        <div class="premium-form-group" class="d-flex justify-content-center mb-4">
                            <div class="g-recaptcha" data-sitekey="<?= $config['gcaptcha_site_key'] ?>"></div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="premium-form-group">
                        <button type="submit" class="btn-premium">
                            Sign In
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="sso-divider">
                        <span>ShopSuite Secure Login</span>
                    </div>

                    <div class="login-footer">
                        &copy; <?= date('Y') ?> ShopSuite. All rights reserved.
                    </div>
                </form>
            </div>
        </div>

    </div>
    
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const btn = this.querySelector('button[type="submit"]');
            
            if (!username || !password) {
                e.preventDefault();
                if (window.shopsuiteApp && window.shopsuiteApp.showToast) {
                    window.shopsuiteApp.showToast('Validation Error', 'Please fill in all required fields', 'error');
                } else {
                    this.parentElement.style.animation = 'none';
                    this.parentElement.offsetHeight;
                    this.parentElement.style.animation = 'shake 0.5s';
                }
                return false;
            }
            
            btn.innerHTML = `
                <svg class="u-animation-spin1slinearinfinite" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke-width="3" stroke-dasharray="31.4 31.4" stroke-linecap="round" />
                </svg>
                Authenticating...
            `;
            btn.style.opacity = '0.9';
            btn.style.pointerEvents = 'none';
        });

        
    </script>
    
    <?php if (!empty($config['gcaptcha_enable'])): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
</body>
</html>
