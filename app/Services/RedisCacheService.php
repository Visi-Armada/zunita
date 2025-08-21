<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class RedisCacheService
{
    /**
     * Cache statistics data with Redis
     */
    public function cacheStatistics(string $key, array $data, int $ttl = 600): bool
    {
        try {
            return Cache::store('redis')->put($key, $data, $ttl);
        } catch (\Exception $e) {
            Log::error('Redis cache error for statistics: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cached statistics data
     */
    public function getCachedStatistics(string $key): ?array
    {
        try {
            return Cache::store('redis')->get($key);
        } catch (\Exception $e) {
            Log::error('Redis cache retrieval error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Cache chart data with Redis
     */
    public function cacheChartData(string $key, array $data, int $ttl = 600): bool
    {
        try {
            return Cache::store('redis')->put($key, $data, $ttl);
        } catch (\Exception $e) {
            Log::error('Redis cache error for chart data: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cached chart data
     */
    public function getCachedChartData(string $key): ?array
    {
        try {
            return Cache::store('redis')->get($key);
        } catch (\Exception $e) {
            Log::error('Redis cache retrieval error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Cache carousel data with Redis
     */
    public function cacheCarouselData(string $key, $data, int $ttl = 300): bool
    {
        try {
            return Cache::store('redis')->put($key, $data, $ttl);
        } catch (\Exception $e) {
            Log::error('Redis cache error for carousel: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cached carousel data
     */
    public function getCachedCarouselData(string $key)
    {
        try {
            return Cache::store('redis')->get($key);
        } catch (\Exception $e) {
            Log::error('Redis cache retrieval error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Clear specific cache keys
     */
    public function clearCache(array $keys): void
    {
        try {
            foreach ($keys as $key) {
                Cache::store('redis')->forget($key);
            }
        } catch (\Exception $e) {
            Log::error('Redis cache clear error: ' . $e->getMessage());
        }
    }

    /**
     * Clear all application cache
     */
    public function clearAllCache(): void
    {
        try {
            Cache::store('redis')->flush();
        } catch (\Exception $e) {
            Log::error('Redis cache flush error: ' . $e->getMessage());
        }
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        try {
            $redis = Redis::connection();
            $info = $redis->info();
            
            return [
                'used_memory' => $info['used_memory_human'] ?? 'N/A',
                'connected_clients' => $info['connected_clients'] ?? 0,
                'total_commands_processed' => $info['total_commands_processed'] ?? 0,
                'keyspace_hits' => $info['keyspace_hits'] ?? 0,
                'keyspace_misses' => $info['keyspace_misses'] ?? 0,
            ];
        } catch (\Exception $e) {
            Log::error('Redis stats error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if Redis is available
     */
    public function isRedisAvailable(): bool
    {
        try {
            $redis = Redis::connection();
            $redis->ping();
            return true;
        } catch (\Exception $e) {
            Log::error('Redis connection error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cache hit rate
     */
    public function getCacheHitRate(): float
    {
        try {
            $redis = Redis::connection();
            $info = $redis->info();
            
            $hits = $info['keyspace_hits'] ?? 0;
            $misses = $info['keyspace_misses'] ?? 0;
            $total = $hits + $misses;
            
            return $total > 0 ? ($hits / $total) * 100 : 0;
        } catch (\Exception $e) {
            Log::error('Redis hit rate error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Set cache with tags for better organization
     */
    public function cacheWithTags(string $key, $data, array $tags, int $ttl = 600): bool
    {
        try {
            return Cache::store('redis')->tags($tags)->put($key, $data, $ttl);
        } catch (\Exception $e) {
            Log::error('Redis tagged cache error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cached data with tags
     */
    public function getCachedWithTags(string $key, array $tags)
    {
        try {
            return Cache::store('redis')->tags($tags)->get($key);
        } catch (\Exception $e) {
            Log::error('Redis tagged cache retrieval error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Clear cache by tags
     */
    public function clearCacheByTags(array $tags): void
    {
        try {
            Cache::store('redis')->tags($tags)->flush();
        } catch (\Exception $e) {
            Log::error('Redis tagged cache clear error: ' . $e->getMessage());
        }
    }
}
