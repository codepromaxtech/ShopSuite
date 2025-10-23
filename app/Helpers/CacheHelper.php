<?php

namespace App\Helpers;

use CodeIgniter\Cache\CacheInterface;

/**
 * Modern Cache Helper with Redis/File support
 * Provides easy caching for database queries and API responses
 */
class CacheHelper
{
    protected CacheInterface $cache;
    protected int $defaultTTL = 3600; // 1 hour
    
    public function __construct()
    {
        $this->cache = \Config\Services::cache();
    }
    
    /**
     * Remember a value in cache, or execute callback if not exists
     */
    public function remember(string $key, int $ttl = null, callable $callback)
    {
        $ttl = $ttl ?? $this->defaultTTL;
        
        // Try to get from cache
        $value = $this->cache->get($key);
        
        if ($value !== null) {
            return $value;
        }
        
        // Execute callback and cache result
        $value = $callback();
        $this->cache->save($key, $value, $ttl);
        
        return $value;
    }
    
    /**
     * Cache database query results
     */
    public function rememberQuery(string $key, callable $query, int $ttl = null)
    {
        return $this->remember($key, $ttl, $query);
    }
    
    /**
     * Cache with tags for easy group invalidation
     */
    public function rememberWithTags(string $key, array $tags, int $ttl = null, callable $callback)
    {
        $value = $this->remember($key, $ttl, $callback);
        
        // Store tag associations
        foreach ($tags as $tag) {
            $tagKey = "tag:{$tag}";
            $keys = $this->cache->get($tagKey) ?? [];
            $keys[] = $key;
            $this->cache->save($tagKey, array_unique($keys), $ttl ?? $this->defaultTTL);
        }
        
        return $value;
    }
    
    /**
     * Invalidate all caches with a specific tag
     */
    public function invalidateTag(string $tag): void
    {
        $tagKey = "tag:{$tag}";
        $keys = $this->cache->get($tagKey) ?? [];
        
        foreach ($keys as $key) {
            $this->cache->delete($key);
        }
        
        $this->cache->delete($tagKey);
    }
    
    /**
     * Get cached value
     */
    public function get(string $key)
    {
        return $this->cache->get($key);
    }
    
    /**
     * Set cached value
     */
    public function set(string $key, $value, int $ttl = null): bool
    {
        return $this->cache->save($key, $value, $ttl ?? $this->defaultTTL);
    }
    
    /**
     * Delete cached value
     */
    public function delete(string $key): bool
    {
        return $this->cache->delete($key);
    }
    
    /**
     * Clear all cache
     */
    public function flush(): bool
    {
        return $this->cache->clean();
    }
    
    /**
     * Check if key exists
     */
    public function has(string $key): bool
    {
        return $this->cache->get($key) !== null;
    }
    
    /**
     * Increment a counter
     */
    public function increment(string $key, int $offset = 1): int
    {
        $value = (int) $this->get($key);
        $value += $offset;
        $this->set($key, $value);
        return $value;
    }
    
    /**
     * Decrement a counter
     */
    public function decrement(string $key, int $offset = 1): int
    {
        $value = (int) $this->get($key);
        $value -= $offset;
        $this->set($key, $value);
        return $value;
    }
    
    /**
     * Cache for a very short time (5 minutes)
     */
    public function rememberShort(string $key, callable $callback)
    {
        return $this->remember($key, 300, $callback);
    }
    
    /**
     * Cache for a long time (24 hours)
     */
    public function rememberLong(string $key, callable $callback)
    {
        return $this->remember($key, 86400, $callback);
    }
    
    /**
     * Cache forever (1 year)
     */
    public function rememberForever(string $key, callable $callback)
    {
        return $this->remember($key, 31536000, $callback);
    }
}
