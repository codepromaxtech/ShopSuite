<?php

namespace App\Helpers;

use CodeIgniter\Cache\CacheInterface;

/**
 * Rate Limiter for API and request throttling
 * Prevents abuse and DDoS attacks
 */
class RateLimiter
{
    protected CacheInterface $cache;
    protected int $maxAttempts = 60; // requests per window
    protected int $decayMinutes = 1; // time window in minutes
    
    public function __construct()
    {
        $this->cache = \Config\Services::cache();
    }
    
    /**
     * Check if request should be allowed
     */
    public function attempt(string $key, int $maxAttempts = null, int $decayMinutes = null): bool
    {
        $maxAttempts = $maxAttempts ?? $this->maxAttempts;
        $decayMinutes = $decayMinutes ?? $this->decayMinutes;
        
        $attempts = $this->attempts($key);
        
        if ($attempts >= $maxAttempts) {
            return false;
        }
        
        $this->hit($key, $decayMinutes);
        return true;
    }
    
    /**
     * Increment hit counter
     */
    public function hit(string $key, int $decayMinutes = null): int
    {
        $decayMinutes = $decayMinutes ?? $this->decayMinutes;
        $cacheKey = $this->getCacheKey($key);
        
        $attempts = (int) $this->cache->get($cacheKey) + 1;
        $this->cache->save($cacheKey, $attempts, $decayMinutes * 60);
        
        // Save timestamp of first attempt
        $timerKey = $cacheKey . ':timer';
        if (!$this->cache->get($timerKey)) {
            $this->cache->save($timerKey, time(), $decayMinutes * 60);
        }
        
        return $attempts;
    }
    
    /**
     * Get number of attempts
     */
    public function attempts(string $key): int
    {
        $cacheKey = $this->getCacheKey($key);
        return (int) $this->cache->get($cacheKey);
    }
    
    /**
     * Reset attempts counter
     */
    public function resetAttempts(string $key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $this->cache->delete($cacheKey);
        $this->cache->delete($cacheKey . ':timer');
        return true;
    }
    
    /**
     * Get remaining attempts
     */
    public function retriesLeft(string $key, int $maxAttempts = null): int
    {
        $maxAttempts = $maxAttempts ?? $this->maxAttempts;
        $attempts = $this->attempts($key);
        
        return max(0, $maxAttempts - $attempts);
    }
    
    /**
     * Clear rate limiter after successful action
     */
    public function clear(string $key): bool
    {
        return $this->resetAttempts($key);
    }
    
    /**
     * Check if too many attempts
     */
    public function tooManyAttempts(string $key, int $maxAttempts = null): bool
    {
        $maxAttempts = $maxAttempts ?? $this->maxAttempts;
        return $this->attempts($key) >= $maxAttempts;
    }
    
    /**
     * Get seconds until rate limit resets
     */
    public function availableIn(string $key): int
    {
        $cacheKey = $this->getCacheKey($key);
        $timerKey = $cacheKey . ':timer';
        
        $firstAttempt = $this->cache->get($timerKey);
        
        if (!$firstAttempt) {
            return 0;
        }
        
        $resetTime = $firstAttempt + ($this->decayMinutes * 60);
        return max(0, $resetTime - time());
    }
    
    /**
     * Get cache key for rate limiter
     */
    protected function getCacheKey(string $key): string
    {
        return 'rate_limit:' . $key;
    }
    
    /**
     * Rate limit by IP address
     */
    public function limitByIp(string $action, int $maxAttempts = null, int $decayMinutes = null): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $key = "{$action}:{$ip}";
        
        return $this->attempt($key, $maxAttempts, $decayMinutes);
    }
    
    /**
     * Rate limit by user ID
     */
    public function limitByUser(string $action, int $userId, int $maxAttempts = null, int $decayMinutes = null): bool
    {
        $key = "{$action}:user:{$userId}";
        return $this->attempt($key, $maxAttempts, $decayMinutes);
    }
    
    /**
     * Rate limit API endpoint
     */
    public function limitApiEndpoint(string $endpoint, string $identifier, int $maxAttempts = 100, int $decayMinutes = 1): array
    {
        $key = "api:{$endpoint}:{$identifier}";
        
        if ($this->tooManyAttempts($key, $maxAttempts)) {
            return [
                'allowed' => false,
                'retry_after' => $this->availableIn($key),
                'message' => 'Too many requests. Please try again later.'
            ];
        }
        
        $this->hit($key, $decayMinutes);
        
        return [
            'allowed' => true,
            'remaining' => $this->retriesLeft($key, $maxAttempts),
            'reset_in' => $decayMinutes * 60
        ];
    }
}
