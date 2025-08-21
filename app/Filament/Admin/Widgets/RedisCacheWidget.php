<?php

namespace App\Filament\Admin\Widgets;

use App\Services\RedisCacheService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RedisCacheWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static bool $isLazy = false;

    public function getStats(): array
    {
        $redisCache = app(RedisCacheService::class);
        
        if (!$redisCache->isRedisAvailable()) {
            return [
                Stat::make('Redis Status', 'Not Available')
                    ->description('Redis connection failed')
                    ->descriptionIcon('heroicon-m-x-circle')
                    ->color('danger'),
            ];
        }

        $stats = $redisCache->getCacheStats();
        $hitRate = $redisCache->getCacheHitRate();

        return [
            Stat::make('Cache Hit Rate', round($hitRate, 1) . '%')
                ->description('Percentage of cache hits')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($hitRate > 80 ? 'success' : ($hitRate > 60 ? 'warning' : 'danger')),

            Stat::make('Memory Usage', $stats['used_memory'] ?? 'N/A')
                ->description('Redis memory consumption')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),

            Stat::make('Connected Clients', $stats['connected_clients'] ?? 0)
                ->description('Active Redis connections')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Commands', number_format($stats['total_commands_processed'] ?? 0))
                ->description('Commands processed by Redis')
                ->descriptionIcon('heroicon-m-command-line')
                ->color('warning'),
        ];
    }
}
