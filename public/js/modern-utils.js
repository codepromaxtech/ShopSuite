/**
 * Modern ES6+ Utility Functions
 * Performance-optimized vanilla JS utilities
 */

// Debounce function for performance
export function debounce(func, wait = 300) {
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

// Throttle function for scroll/resize events
export function throttle(func, limit = 100) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Modern AJAX with fetch API
export async function fetchJSON(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...options.headers
            },
            ...options
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
}

// Post data with fetch API
export async function postJSON(url, data, options = {}) {
    return fetchJSON(url, {
        method: 'POST',
        body: JSON.stringify(data),
        ...options
    });
}

// Local Storage with expiry
export const storage = {
    set(key, value, expiryMinutes = 60) {
        const item = {
            value: value,
            expiry: Date.now() + (expiryMinutes * 60 * 1000)
        };
        localStorage.setItem(key, JSON.stringify(item));
    },
    
    get(key) {
        const itemStr = localStorage.getItem(key);
        if (!itemStr) return null;
        
        try {
            const item = JSON.parse(itemStr);
            if (Date.now() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        } catch {
            return null;
        }
    },
    
    remove(key) {
        localStorage.removeItem(key);
    },
    
    clear() {
        localStorage.clear();
    }
};

// DOM Ready - Modern alternative to $(document).ready()
export function ready(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

// Query selector shortcuts
export const $ = (selector, parent = document) => parent.querySelector(selector);
export const $$ = (selector, parent = document) => Array.from(parent.querySelectorAll(selector));

// Element creation helper
export function createElement(tag, props = {}, children = []) {
    const element = document.createElement(tag);
    
    Object.entries(props).forEach(([key, value]) => {
        if (key === 'className') {
            element.className = value;
        } else if (key === 'style' && typeof value === 'object') {
            Object.assign(element.style, value);
        } else if (key.startsWith('on') && typeof value === 'function') {
            element.addEventListener(key.substring(2).toLowerCase(), value);
        } else {
            element.setAttribute(key, value);
        }
    });
    
    children.forEach(child => {
        if (typeof child === 'string') {
            element.appendChild(document.createTextNode(child));
        } else if (child instanceof Node) {
            element.appendChild(child);
        }
    });
    
    return element;
}

// Event delegation
export function delegate(parent, selector, event, handler) {
    parent.addEventListener(event, (e) => {
        const target = e.target.closest(selector);
        if (target) {
            handler.call(target, e);
        }
    });
}

// Copy to clipboard
export async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
        return true;
    } catch (err) {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        const success = document.execCommand('copy');
        document.body.removeChild(textarea);
        return success;
    }
}

// Format currency
export function formatCurrency(amount, currency = 'USD', locale = 'en-US') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency
    }).format(amount);
}

// Format date
export function formatDate(date, options = {}) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        ...options
    }).format(new Date(date));
}

// Format relative time (e.g., "2 hours ago")
export function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1
    };
    
    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / secondsInUnit);
        if (interval >= 1) {
            return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
        }
    }
    
    return 'just now';
}

// Validate email
export function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Validate phone
export function isValidPhone(phone) {
    return /^[\d\s\-\+\(\)]+$/.test(phone);
}

// Generate UUID
export function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
        const r = Math.random() * 16 | 0;
        const v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

// Lazy load images
export function lazyLoadImages() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        $$('img.lazy').forEach(img => imageObserver.observe(img));
    }
}

// Performance monitoring
export const perf = {
    start(mark) {
        performance.mark(`${mark}-start`);
    },
    
    end(mark) {
        performance.mark(`${mark}-end`);
        performance.measure(mark, `${mark}-start`, `${mark}-end`);
        const measure = performance.getEntriesByName(mark)[0];
        console.log(`⏱️ ${mark}: ${measure.duration.toFixed(2)}ms`);
        return measure.duration;
    },
    
    clear() {
        performance.clearMarks();
        performance.clearMeasures();
    }
};

// Cache API wrapper
export const cache = {
    async set(key, data, maxAge = 3600) {
        if ('caches' in window) {
            try {
                const cache = await caches.open('api-cache');
                const response = new Response(JSON.stringify(data), {
                    headers: {
                        'Content-Type': 'application/json',
                        'Cache-Control': `max-age=${maxAge}`
                    }
                });
                await cache.put(key, response);
            } catch (err) {
                console.warn('Cache set failed:', err);
            }
        }
    },
    
    async get(key) {
        if ('caches' in window) {
            try {
                const cache = await caches.open('api-cache');
                const response = await cache.match(key);
                if (response) {
                    return await response.json();
                }
            } catch (err) {
                console.warn('Cache get failed:', err);
            }
        }
        return null;
    },
    
    async clear() {
        if ('caches' in window) {
            const names = await caches.keys();
            await Promise.all(names.map(name => caches.delete(name)));
        }
    }
};

// Network status detection
export const network = {
    isOnline() {
        return navigator.onLine;
    },
    
    onStatusChange(callback) {
        window.addEventListener('online', () => callback(true));
        window.addEventListener('offline', () => callback(false));
    }
};

console.log('✨ Modern Utils Loaded');
