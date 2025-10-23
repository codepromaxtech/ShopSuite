<?php

namespace App\Traits;

use App\Helpers\CacheHelper;

/**
 * Performance Monitoring Trait
 * Add to controllers for automatic performance tracking
 */
trait PerformanceMonitoring
{
    protected array $performanceMetrics = [];
    protected ?CacheHelper $cacheHelper = null;
    
    /**
     * Start performance timer
     */
    protected function perfStart(string $metric): void
    {
        $this->performanceMetrics[$metric] = [
            'start' => microtime(true),
            'memory_start' => memory_get_usage()
        ];
    }
    
    /**
     * End performance timer and log
     */
    protected function perfEnd(string $metric): array
    {
        if (!isset($this->performanceMetrics[$metric])) {
            return ['error' => 'Metric not started'];
        }
        
        $start = $this->performanceMetrics[$metric];
        $duration = (microtime(true) - $start['start']) * 1000; // ms
        $memory = memory_get_usage() - $start['memory_start'];
        
        $result = [
            'metric' => $metric,
            'duration_ms' => round($duration, 2),
            'memory_bytes' => $memory,
            'memory_mb' => round($memory / 1024 / 1024, 2)
        ];
        
        // Log if slow
        if ($duration > 1000) { // > 1 second
            log_message('warning', "Slow operation: {$metric} took {$result['duration_ms']}ms");
        }
        
        return $result;
    }
    
    /**
     * Get cache helper instance
     */
    protected function getCacheHelper(): CacheHelper
    {
        if ($this->cacheHelper === null) {
            $this->cacheHelper = new CacheHelper();
        }
        return $this->cacheHelper;
    }
    
    /**
     * Cache database query with monitoring
     */
    protected function cachedQuery(string $key, callable $query, int $ttl = 3600)
    {
        $this->perfStart("cache_query:{$key}");
        
        $result = $this->getCacheHelper()->remember($key, $ttl, function() use ($query, $key) {
            $this->perfStart("db_query:{$key}");
            $data = $query();
            $metrics = $this->perfEnd("db_query:{$key}");
            log_message('debug', "Query {$key}: {$metrics['duration_ms']}ms");
            return $data;
        });
        
        $this->perfEnd("cache_query:{$key}");
        
        return $result;
    }
    
    /**
     * Batch process with progress tracking
     */
    protected function batchProcess(array $items, callable $callback, int $batchSize = 100): array
    {
        $results = [];
        $total = count($items);
        $processed = 0;
        
        $this->perfStart('batch_process');
        
        foreach (array_chunk($items, $batchSize) as $batch) {
            foreach ($batch as $item) {
                $results[] = $callback($item);
                $processed++;
            }
            
            // Log progress
            $progress = round(($processed / $total) * 100, 1);
            log_message('info', "Batch progress: {$progress}% ({$processed}/{$total})");
            
            // Allow garbage collection
            gc_collect_cycles();
        }
        
        $metrics = $this->perfEnd('batch_process');
        log_message('info', "Batch completed in {$metrics['duration_ms']}ms");
        
        return $results;
    }
    
    /**
     * Measure database query performance
     */
    protected function measureQuery(string $description, callable $query)
    {
        $this->perfStart($description);
        $result = $query();
        $metrics = $this->perfEnd($description);
        
        // Log slow queries
        if ($metrics['duration_ms'] > 100) {
            log_message('warning', "Slow query detected: {$description} - {$metrics['duration_ms']}ms");
        }
        
        return $result;
    }
    
    /**
     * Get all performance metrics
     */
    protected function getPerformanceReport(): array
    {
        return [
            'metrics' => $this->performanceMetrics,
            'peak_memory_mb' => round(memory_get_peak_usage() / 1024 / 1024, 2),
            'current_memory_mb' => round(memory_get_usage() / 1024 / 1024, 2),
            'execution_time_s' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3)
        ];
    }
    
    /**
     * Log performance report to file
     */
    protected function logPerformanceReport(): void
    {
        $report = $this->getPerformanceReport();
        log_message('info', 'Performance Report: ' . json_encode($report));
    }
}
