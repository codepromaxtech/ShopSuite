/**
 * Service Worker for ShopSuite - DISABLED
 * Service worker is disabled to prevent cache-related issues
 * Can be re-enabled once the application is stable
 */

console.log('Service Worker: Disabled (no caching active)');

// Install event - do nothing
self.addEventListener('install', (event) => {
    console.log('Service Worker: Install (disabled)');
    self.skipWaiting();
});

// Activate event - clean up ALL caches
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activate (disabled, clearing all caches)');
    
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames.map(name => caches.delete(name))
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch event - disabled, pass all requests through
self.addEventListener('fetch', (event) => {
    // Do nothing - let all requests pass through normally
    return;
});

console.log('Service Worker: Loaded (disabled, no caching)');
