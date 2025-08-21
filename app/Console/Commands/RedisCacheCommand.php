<?php

namespace App\Console\Commands;

use App\Services\RedisCacheService;
use Illuminate\Console\Command;

class RedisCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:cache {action : Action to perform (status|clear|stats|warm)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage Redis cache operations';

    protected $redisCache;

    public function __construct(RedisCacheService $redisCache)
    {
        parent::__construct();
        $this->redisCache = $redisCache;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'status':
                $this->showStatus();
                break;
            case 'clear':
                $this->clearCache();
                break;
            case 'stats':
                $this->showStats();
                break;
            case 'warm':
                $this->warmCache();
                break;
            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: status, clear, stats, warm');
                return 1;
        }

        return 0;
    }

    /**
     * Show Redis connection status
     */
    private function showStatus()
    {
        $this->info('Checking Redis connection...');

        if ($this->redisCache->isRedisAvailable()) {
            $this->info('✅ Redis is available and connected');
        } else {
            $this->error('❌ Redis is not available');
        }
    }

    /**
     * Clear all cache
     */
    private function clearCache()
    {
        $this->info('Clearing Redis cache...');

        if ($this->confirm('Are you sure you want to clear all cache?')) {
            $this->redisCache->clearAllCache();
            $this->info('✅ Cache cleared successfully');
        } else {
            $this->info('Cache clear cancelled');
        }
    }

    /**
     * Show cache statistics
     */
    private function showStats()
    {
        $this->info('Redis Cache Statistics:');
        $this->newLine();

        $stats = $this->redisCache->getCacheStats();
        $hitRate = $this->redisCache->getCacheHitRate();

        if (empty($stats)) {
            $this->error('Unable to retrieve cache statistics');
            return;
        }

        $this->table(
            ['Metric', 'Value'],
            [
                ['Used Memory', $stats['used_memory'] ?? 'N/A'],
                ['Connected Clients', $stats['connected_clients'] ?? 0],
                ['Total Commands', $stats['total_commands_processed'] ?? 0],
                ['Cache Hits', $stats['keyspace_hits'] ?? 0],
                ['Cache Misses', $stats['keyspace_misses'] ?? 0],
                ['Hit Rate', round($hitRate, 2) . '%'],
            ]
        );
    }

    /**
     * Warm up cache with frequently accessed data
     */
    private function warmCache()
    {
        $this->info('Warming up Redis cache...');

        try {
            // Warm up statistics
            $this->info('Caching dashboard statistics...');
            app(\App\Services\StatisticsService::class)->getDashboardStatistics();

            // Warm up chart data
            $this->info('Caching chart data...');
            app(\App\Services\StatisticsService::class)->getChartData();

            // Warm up carousel data
            $this->info('Caching carousel data...');
            app(\App\Services\CarouselService::class)->getActiveCarousels();

            $this->info('✅ Cache warming completed successfully');
        } catch (\Exception $e) {
            $this->error('❌ Cache warming failed: ' . $e->getMessage());
        }
    }
}
