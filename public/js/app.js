/**
 * SHOPSUITE - CORE APPLICATION JAVASCRIPT
 * Theme Management, Input Mode, Sidebar, Utilities
 */

class ShopSuiteApp {
    constructor() {
        this.settings = {
            theme: 'dark',
            inputMode: 'regular',
            sidebarCollapsed: false
        };

        this.init();
    }

    init() {
        this.loadSettings();
        this.applyTheme();
        this.applyInputMode();
        this.setupEventListeners();
        this.initSidebar();
        this.initNotifications();
    }

    // ============================================
    // SETTINGS MANAGEMENT
    // ============================================
    loadSettings() {
        const saved = localStorage.getItem('shopsuite_settings');
        if (saved) {
            this.settings = { ...this.settings, ...JSON.parse(saved) };
        }
    }

    saveSettings() {
        localStorage.setItem('shopsuite_settings', JSON.stringify(this.settings));
    }

    // ============================================
    // THEME MANAGEMENT
    // ============================================
    applyTheme() {
        document.documentElement.setAttribute('data-theme', this.settings.theme);
    }

    toggleTheme() {
        this.settings.theme = this.settings.theme === 'light' ? 'dark' : 'light';
        this.applyTheme();
        this.saveSettings();
        this.showToast('Theme Changed', `Switched to ${this.settings.theme} mode`, 'success');
    }

    setTheme(theme) {
        if (['light', 'dark'].includes(theme)) {
            this.settings.theme = theme;
            this.applyTheme();
            this.saveSettings();
        }
    }

    // ============================================
    // INPUT MODE MANAGEMENT
    // ============================================
    applyInputMode() {
        document.documentElement.setAttribute('data-input-mode', this.settings.inputMode);
    }

    toggleInputMode() {
        this.settings.inputMode = this.settings.inputMode === 'regular' ? 'touch' : 'regular';
        this.applyInputMode();
        this.saveSettings();
        this.showToast('Input Mode Changed', `Switched to ${this.settings.inputMode} mode`, 'success');
    }

    setInputMode(mode) {
        if (['regular', 'touch'].includes(mode)) {
            this.settings.inputMode = mode;
            this.applyInputMode();
            this.saveSettings();
        }
    }

    // ============================================
    // SIDEBAR MANAGEMENT
    // ============================================
    initSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (!sidebar) return;

        if (this.settings.sidebarCollapsed) {
            sidebar.classList.add('collapsed');
        }

        // Mobile: Close sidebar by default
        if (window.innerWidth < 1024) {
            sidebar.classList.remove('open');
        }
    }

    toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (!sidebar) return;

        if (window.innerWidth < 1024) {
            // Mobile: Toggle open/close
            sidebar.classList.toggle('open');
            this.toggleSidebarOverlay();
        } else {
            // Desktop: Toggle collapsed
            sidebar.classList.toggle('collapsed');
            this.settings.sidebarCollapsed = sidebar.classList.contains('collapsed');
            this.saveSettings();
        }
    }

    toggleSidebarOverlay() {
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.addEventListener('click', () => this.closeSidebar());
            document.body.appendChild(overlay);
        }
        overlay.classList.toggle('show');
    }

    closeSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.remove('open');
        }
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.classList.remove('show');
        }
    }

    // ============================================
    // DROPDOWN MANAGEMENT
    // ============================================
    setupDropdowns() {
        document.querySelectorAll('[data-dropdown-toggle]').forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const targetId = toggle.getAttribute('data-dropdown-toggle');
                const dropdown = document.getElementById(targetId);
                if (dropdown) {
                    const isVisible = dropdown.style.display === 'block';
                    this.closeAllDropdowns();
                    dropdown.style.display = isVisible ? 'none' : 'block';
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', () => {
            this.closeAllDropdowns();
        });

        // Prevent dropdown from closing when clicking inside
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    }

    closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }

    // ============================================
    // MODAL MANAGEMENT
    // ============================================
    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    setupModals() {
        // Close modal when clicking backdrop
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) {
                    backdrop.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        });

        // Close modal buttons
        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.getAttribute('data-modal-close');
                this.closeModal(modalId);
            });
        });

        // Open modal buttons
        document.querySelectorAll('[data-modal-open]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.getAttribute('data-modal-open');
                this.showModal(modalId);
            });
        });
    }

    // ============================================
    // TOAST NOTIFICATIONS
    // ============================================
    showToast(title, message, type = 'info', duration = 3000) {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast';

        const icons = {
            success: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
            error: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
            warning: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            info: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };

        toast.innerHTML = `
            ${icons[type] || icons.info}
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message text-sm">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        container.appendChild(toast);

        if (duration > 0) {
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }
    }

    // ============================================
    // APPLICATION NOTIFICATIONS (DROPDOWN)
    // ============================================
    initNotifications() {
        this.fetchNotifications();

        // Poll every 60 seconds
        setInterval(() => this.fetchNotifications(), 60000);

        // Setup mark all as read
        const markAllBtn = document.getElementById('markAllNotificationsReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.markAllNotificationsRead();
            });
        }
    }

    async fetchNotifications() {
        try {
            const baseUrl = typeof window.shopsuiteConfig !== 'undefined' ? window.shopsuiteConfig.baseUrl : '';
            const response = await fetch(baseUrl + '/notifications/get_unread', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });

            // Bail silently on any non-OK response (server error, redirect, etc.)
            if (!response.ok) return;

            // Guard against HTML error pages — verify content-type before parsing
            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) return;

            const data = await response.json();
            if (data.success) {
                this.updateNotificationUI(data.notifications, data.count);
            }
        } catch (error) {
            // Silent fail — this runs on a 60s poll, no need to spam console
        }
    }

    updateNotificationUI(notifications, count) {
        const badge = document.getElementById('globalNotificationBadge');
        const list = document.getElementById('globalNotificationsList');

        if (!badge || !list) return;

        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.textContent = '0';
            badge.classList.add('hidden');
        }

        if (notifications.length === 0) {
            list.innerHTML = '<div style="padding: 16px; text-align: center; color: var(--text-tertiary); font-size: 13px;">No new notifications</div>';
            return;
        }

        let html = '';
        notifications.forEach(notif => {
            let dateStr = new Date(notif.created_at).toLocaleString();
            html += `
                <div class="notification-item" style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); cursor: pointer;" onclick="shopsuiteApp.markNotificationReadAndNavigate(${notif.id}, '${notif.link || '#'}')">
                    <div style="font-weight: 600; font-size: 13px; color: var(--text-primary); margin-bottom: 4px;">${notif.title}</div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-bottom: 6px;">${notif.message}</div>
                    <div style="font-size: 11px; color: var(--text-tertiary);">${dateStr}</div>
                </div>
            `;
        });

        list.innerHTML = html;

        // Add hover styles dynamically
        const items = list.querySelectorAll('.notification-item');
        items.forEach(item => {
            item.addEventListener('mouseenter', () => { item.style.backgroundColor = 'var(--bg-secondary)'; });
            item.addEventListener('mouseleave', () => { item.style.backgroundColor = 'transparent'; });
        });
    }

    async markNotificationReadAndNavigate(id, link) {
        try {
            const baseUrl = typeof window.shopsuiteConfig !== 'undefined' ? window.shopsuiteConfig.baseUrl : '';
            const response = await this.postAction(baseUrl + '/notifications/mark_read', { id: id });

            // Navigate regardless of success — don't block the user
            if (link && link !== '#') {
                window.location.href = link;
            } else if (response.ok) {
                this.fetchNotifications();
            }
        } catch (error) {
            // Still navigate on error
            if (link && link !== '#') window.location.href = link;
        }
    }

    async markAllNotificationsRead() {
        try {
            const baseUrl = typeof window.shopsuiteConfig !== 'undefined' ? window.shopsuiteConfig.baseUrl : '';
            const response = await this.postAction(baseUrl + '/notifications/mark_all_read');

            if (!response.ok) return;

            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) return;

            const data = await response.json();
            if (data.success) {
                this.fetchNotifications();
            }
        } catch (error) {
            console.error('Error marking notifications as read:', error);
        }
    }

    // ============================================
    // CONFIRMATION DIALOG
    // ============================================
    confirm(title, message, onConfirm, onCancel = null) {
        const confirmModal = document.createElement('div');
        confirmModal.className = 'modal-backdrop';
        confirmModal.style.display = 'flex';

        confirmModal.innerHTML = `
            <div class="modal" style="max-width: 400px;">
                <div class="modal-header">
                    <h3 class="modal-title">${title}</h3>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-action="cancel">Cancel</button>
                    <button class="btn btn-danger" data-action="confirm">Confirm</button>
                </div>
            </div>
        `;

        document.body.appendChild(confirmModal);
        document.body.style.overflow = 'hidden';

        const removeModal = () => {
            confirmModal.remove();
            document.body.style.overflow = '';
        };

        confirmModal.querySelector('[data-action="confirm"]').addEventListener('click', () => {
            removeModal();
            if (onConfirm) onConfirm();
        });

        confirmModal.querySelector('[data-action="cancel"]').addEventListener('click', () => {
            removeModal();
            if (onCancel) onCancel();
        });

        confirmModal.addEventListener('click', (e) => {
            if (e.target === confirmModal) {
                removeModal();
                if (onCancel) onCancel();
            }
        });
    }

    // ============================================
    // LOADING STATE
    // ============================================
    showLoading(message = 'Loading...') {
        let overlay = document.querySelector('.loading-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-content">
                    <div class="spinner spinner-lg"></div>
                    <div class="loading-text">${message}</div>
                </div>
            `;
            document.body.appendChild(overlay);
        }
        overlay.style.display = 'flex';
    }

    hideLoading() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    // ============================================
    // CSRF (meta-tag based, for fetch POST actions)
    // Cookie is httpOnly so JS cannot read it directly.
    // The hash is injected into a meta tag by the layout.
    // ============================================
    getCsrfTokenName() {
        return document.querySelector('meta[name="csrf-token-name"]')?.content || 'csrf_shopsuite_v4';
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-hash"]')?.content || '';
    }

    getCsrfFormBody(extraParams = {}) {
        const body = new URLSearchParams();

        Object.entries(extraParams).forEach(([key, value]) => {
            body.set(key, value);
        });
        body.set(this.getCsrfTokenName(), this.getCsrfToken());

        return body;
    }

    postAction(url, extraParams = {}) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': this.getCsrfToken(),
            },
            body: this.getCsrfFormBody(extraParams).toString(),
        });
    }

    // ============================================
    // EVENT LISTENERS SETUP
    // ============================================
    setupEventListeners() {
        // Sidebar toggle
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action="toggle-sidebar"]') ||
                e.target.closest('[data-action="toggle-sidebar"]')) {
                this.toggleSidebar();
            }

            // Theme toggle
            if (e.target.matches('[data-action="toggle-theme"]') ||
                e.target.closest('[data-action="toggle-theme"]')) {
                this.toggleTheme();
            }

            // Input mode toggle
            if (e.target.matches('[data-action="toggle-input-mode"]') ||
                e.target.closest('[data-action="toggle-input-mode"]')) {
                this.toggleInputMode();
            }
        });

        // Setup dropdowns after DOM is ready
        this.setupDropdowns();
        this.setupModals();

        // Close sidebar on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                this.closeSidebar();
            }
        });

        // Active menu highlighting
        this.highlightActiveMenu();
    }

    // ============================================
    // ACTIVE MENU HIGHLIGHTING
    // ============================================
    highlightActiveMenu() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-menu-link').forEach(link => {
            const linkPath = new URL(link.href).pathname;
            if (linkPath === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    formatCurrency(amount, currency = 'USD') {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: currency
        }).format(amount);
    }

    formatDate(date, format = 'short') {
        const options = format === 'long'
            ? { year: 'numeric', month: 'long', day: 'numeric' }
            : { year: 'numeric', month: 'short', day: 'numeric' };
        return new Intl.DateTimeFormat('en-US', options).format(new Date(date));
    }

    formatNumber(number) {
        return new Intl.NumberFormat('en-US').format(number);
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize app when DOM is ready
let app;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        app = new ShopSuiteApp();
        window.shopsuiteApp = app;
    });
} else {
    app = new ShopSuiteApp();
    window.shopsuiteApp = app;
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ShopSuiteApp;
}
