/**
 * Modern Features JavaScript
 * Includes: Dark Mode, Animations, Export Functions, Loading States
 */

// Dark Mode Toggle
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    const icon = document.getElementById('theme-icon');
    
    // Set new theme
    html.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update icon
    if (newTheme === 'dark') {
        icon.className = 'bi bi-sun-fill';
    } else {
        icon.className = 'bi bi-moon-stars';
    }
    
    // Animate toggle
    const button = document.querySelector('.theme-toggle');
    button.style.transform = 'scale(0.9) rotate(180deg)';
    setTimeout(() => {
        button.style.transform = '';
    }, 300);
}

// Initialize theme on load
(function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
    
    const icon = document.getElementById('theme-icon');
    if (icon) {
        icon.className = savedTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars';
    }
})();

// Sidebar Toggle for Mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-toggle');
    
    if (window.innerWidth <= 768 && 
        sidebar && 
        sidebar.classList.contains('show') && 
        !sidebar.contains(event.target) && 
        !toggle.contains(event.target)) {
        sidebar.classList.remove('show');
    }
});

// Export to Excel
function exportToExcel(tableId = 'table') {
    try {
        const table = document.getElementById(tableId);
        if (!table) {
            showNotification('Table not found!', 'error');
            return;
        }
        
        // Use Bootstrap Table export if available
        if ($(table).data('bootstrap.table')) {
            $(table).bootstrapTable('exportTable', {
                type: 'excel',
                fileName: 'export_' + Date.now()
            });
        } else {
            showNotification('Export functionality not available', 'warning');
        }
    } catch (error) {
        console.error('Export error:', error);
        showNotification('Export failed', 'error');
    }
}

// Export to PDF
function exportToPDF(tableId = 'table') {
    try {
        const table = document.getElementById(tableId);
        if (!table) {
            showNotification('Table not found!', 'error');
            return;
        }
        
        // Use Bootstrap Table export if available
        if ($(table).data('bootstrap.table')) {
            $(table).bootstrapTable('exportTable', {
                type: 'pdf',
                fileName: 'export_' + Date.now()
            });
        } else {
            showNotification('Export functionality not available', 'warning');
        }
    } catch (error) {
        console.error('Export error:', error);
        showNotification('Export failed', 'error');
    }
}

// Export to CSV
function exportToCSV(tableId = 'table') {
    try {
        const table = document.getElementById(tableId);
        if (!table) {
            showNotification('Table not found!', 'error');
            return;
        }
        
        // Use Bootstrap Table export if available
        if ($(table).data('bootstrap.table')) {
            $(table).bootstrapTable('exportTable', {
                type: 'csv',
                fileName: 'export_' + Date.now()
            });
        } else {
            showNotification('Export functionality not available', 'warning');
        }
    } catch (error) {
        console.error('Export error:', error);
        showNotification('Export failed', 'error');
    }
}

// Show Loading State
function showLoading(message = 'Loading...') {
    const loadingHtml = `
        <div class="loading-overlay" id="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">${message}</span>
            </div>
            <div class="mt-3 text-muted">${message}</div>
        </div>
    `;
    
    // Add loading styles if not already present
    if (!document.getElementById('loading-styles')) {
        const style = document.createElement('style');
        style.id = 'loading-styles';
        style.textContent = `
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                backdrop-filter: blur(4px);
            }
            .loading-overlay .spinner-border {
                width: 3rem;
                height: 3rem;
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.insertAdjacentHTML('beforeend', loadingHtml);
}

// Hide Loading State
function hideLoading() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Show Modern Notification
function showNotification(message, type = 'success', duration = 3000) {
    // Use SweetAlert2 if available
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        const icons = {
            success: 'success',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };
        
        Toast.fire({
            icon: icons[type] || 'info',
            title: message
        });
    } else {
        // Fallback to native notification
        alert(message);
    }
}

// Confirm Dialog using SweetAlert2
function confirmAction(title, text, confirmText = 'Yes', cancelText = 'No') {
    return new Promise((resolve) => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true
            }).then((result) => {
                resolve(result.isConfirmed);
            });
        } else {
            resolve(confirm(text));
        }
    });
}

// Add Fade In Animation to Elements
function animateIn(selector, delay = 0) {
    setTimeout(() => {
        document.querySelectorAll(selector).forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                el.style.transition = 'all 0.3s ease';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 50);
        });
    }, delay);
}

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards
    animateIn('.card', 100);
    
    // Animate buttons
    animateIn('.btn-group', 200);
    
    // Add smooth scroll to all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Auto-save form data to localStorage
function autoSaveForm(formId, interval = 5000) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    // Load saved data
    const savedData = localStorage.getItem('form_' + formId);
    if (savedData) {
        const data = JSON.parse(savedData);
        Object.keys(data).forEach(key => {
            const input = form.elements[key];
            if (input && input.value === '') {
                input.value = data[key];
            }
        });
    }
    
    // Auto-save on interval
    setInterval(() => {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        localStorage.setItem('form_' + formId, JSON.stringify(data));
    }, interval);
}

// Clear auto-saved form data
function clearAutoSave(formId) {
    localStorage.removeItem('form_' + formId);
}

console.log('✨ Modern Features Loaded');
