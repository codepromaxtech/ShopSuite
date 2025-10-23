/**
 * Service Worker for ShopSuite
 * Provides offline support and caching
 */

const CACHE_NAME = 'shopsuite-v1';
const RUNTIME_CACHE = 'shopsuite-runtime';

// Assets to cache on install (only valid local files)
const PRECACHE_ASSETS = [
    '/js/modern-features.js',
    '/js/modern-table.js',
    '/js/modern-modal.js',
    '/css/modern-pos.css'
];

// Install event - cache core assets
self.addEventListener('install', (event) => {
    console.log('Service Worker: Installing...');
    
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Service Worker: Caching core assets');
                // Try to cache each asset individually to avoid failing the entire cache
                return Promise.allSettled(
                    PRECACHE_ASSETS.map(url => 
                        cache.add(url).catch(err => {
                            console.warn(`Failed to cache ${url}:`, err.message);
                            return null;
                        })
                    )
                );
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activating...');
    
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(name => name !== CACHE_NAME && name !== RUNTIME_CACHE)
                        .map(name => caches.delete(name))
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Skip cross-origin requests
    if (url.origin !== location.origin) {
        return;
    }
    
    // Skip POST requests
    if (request.method !== 'GET') {
        return;
    }
    
    event.respondWith(
        caches.match(request)
            .then(cachedResponse => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                
                return fetch(request)
                    .then(response => {
                        // Don't cache if not successful
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }
                        
                        // Cache runtime assets
                        const responseToCache = response.clone();
                        caches.open(RUNTIME_CACHE)
                            .then(cache => {
                                cache.put(request, responseToCache);
                            });
                        
                        return response;
                    })
                    .catch(() => {
                        // Return offline page if available
                        return caches.match('/offline.html');
                    });
            })
    );
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
    console.log('Service Worker: Background sync', event.tag);
    
    if (event.tag === 'sync-data') {
        event.waitUntil(syncData());
    }
});

async function syncData() {
    // Get pending requests from IndexedDB
    // Send them when back online
    console.log('Syncing offline data...');
}

// Push notifications
self.addEventListener('push', (event) => {
    const options = {
        body: event.data ? event.data.text() : 'New notification',
        icon: '/images/icon-192.png',
        badge: '/images/badge-72.png',
        vibrate: [200, 100, 200],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'View',
                icon: '/images/checkmark.png'
            },
            {
                action: 'close',
                title: 'Close',
                icon: '/images/xmark.png'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('ShopSuite', options)
    );
});

// Notification click
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    if (event.action === 'explore') {
        clients.openWindow('/');
    }
});

console.log('Service Worker: Loaded');
