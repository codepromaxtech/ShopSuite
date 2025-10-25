<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0ea5e9">
    <title>Login - ShopSuite</title>
    
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/components.css') ?>">
    
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 50%, var(--accent-600) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .login-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: backgroundMove 20s linear infinite;
        }
        
        @keyframes backgroundMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }
        
        .login-card {
            background-color: var(--bg-elevated);
            border-radius: var(--radius-2xl);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: var(--space-8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: var(--space-8);
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-4);
            background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: var(--text-3xl);
            font-weight: var(--font-bold);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.3);
        }
        
        .login-title {
            font-size: var(--text-3xl);
            font-weight: var(--font-bold);
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }
        
        .login-subtitle {
            color: var(--text-secondary);
            font-size: var(--text-base);
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }
        
        .login-footer {
            margin-top: var(--space-6);
            padding-top: var(--space-6);
            border-top: 1px solid var(--divider-color);
            text-align: center;
        }
        
        .login-links {
            display: flex;
            justify-content: center;
            gap: var(--space-4);
            font-size: var(--text-sm);
            color: var(--text-secondary);
        }
        
        .login-links a {
            color: var(--primary-600);
        }
        
        .theme-toggle-login {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            width: 48px;
            height: 48px;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            color: white;
        }
        
        .theme-toggle-login:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: rotate(180deg);
        }
        
        @media (max-width: 639px) {
            .login-card {
                padding: var(--space-6);
            }
            
            .login-title {
                font-size: var(--text-2xl);
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Theme Toggle -->
        <button class="theme-toggle-login" data-action="toggle-theme" title="Toggle Theme">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
        
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">SS</div>
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to your ShopSuite account</p>
                </div>
                
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="alert-content">
                            <div class="alert-title">Login Failed</div>
                            <div><?= esc($error_message) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('login') ?>" method="post" class="login-form" id="loginForm">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="username" class="form-label form-label-required">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="username" 
                                name="username" 
                                placeholder="Enter your username"
                                value="<?= esc($username ?? '') ?>"
                                required 
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label form-label-required">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            >
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label for="remember" class="text-sm">Remember me for 30 days</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </button>
                </form>
                
                <div class="login-footer">
                    <div class="login-links">
                        <a href="#">Forgot Password?</a>
                        <span>•</span>
                        <a href="#">Need Help?</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center" style="margin-top: var(--space-6); color: rgba(255,255,255,0.8);">
                <p style="font-size: var(--text-sm);">
                    &copy; <?= date('Y') ?> ShopSuite. All rights reserved.
                </p>
            </div>
        </div>
    </div>
    
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script>
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                if (window.shopsuiteApp) {
                    window.shopsuiteApp.showToast('Validation Error', 'Please fill in all required fields', 'error');
                }
                return false;
            }
        });
    </script>
</body>
</html>
