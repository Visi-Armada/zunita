<?php

namespace App\Services;

use App\Models\Contribution;
use App\Models\Initiative;
use App\Models\PublicUser;
use App\Models\InitiativeApplication;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Services\RedisCacheService;

class StatisticsService
{
    protected $redisCache;

    public function __construct(RedisCacheService $redisCache)
    {
        $this->redisCache = $redisCache;
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStatistics(): array
    {
        // Try Redis first, fallback to default cache
        if ($this->redisCache->isRedisAvailable()) {
            $cached = $this->redisCache->getCachedStatistics('dashboard_statistics');
            if ($cached !== null) {
                return $cached;
            }
        }

        $data = [
            'contributions' => $this->getTotalContributions(),
            'recipients' => $this->getTotalRecipients(),
            'initiatives' => $this->getTotalInitiatives(),
            'amount' => $this->getTotalAmount(),
            'average_contribution' => $this->getAverageContribution(),
            'success_rate' => $this->getSuccessRate(),
            'recent_activity' => $this->getRecentActivity(),
            'geographic_distribution' => $this->getGeographicDistribution(),
            'monthly_growth' => $this->getMonthlyGrowth(),
            'top_categories' => $this->getTopCategories(),
        ];

        // Cache in Redis if available
        if ($this->redisCache->isRedisAvailable()) {
            $this->redisCache->cacheStatistics('dashboard_statistics', $data, 600);
        } else {
            // Fallback to default cache
            Cache::remember('dashboard_statistics', 600, function () use ($data) {
                return $data;
            });
        }

        return $data;
    }

    /**
     * Get chart data for the dashboard
     */
    public function getChartData(): array
    {
        // Try Redis first, fallback to default cache
        if ($this->redisCache->isRedisAvailable()) {
            $cached = $this->redisCache->getCachedChartData('chart_data');
            if ($cached !== null) {
                return $cached;
            }
        }

        $data = [
            'categoryData' => $this->getCategoryDistribution(),
            'monthlyData' => $this->getMonthlyTrend(),
            'applicationStatus' => $this->getApplicationStatus(),
        ];

        // Cache in Redis if available
        if ($this->redisCache->isRedisAvailable()) {
            $this->redisCache->cacheChartData('chart_data', $data, 600);
        } else {
            // Fallback to default cache
            Cache::remember('chart_data', 600, function () use ($data) {
                return $data;
            });
        }

        return $data;
    }

    /**
     * Get total contributions count
     */
    private function getTotalContributions(): int
    {
        return Cache::remember('total_contributions', 300, function () {
            return Contribution::count();
        });
    }

    /**
     * Get total recipients count
     */
    private function getTotalRecipients(): int
    {
        return Cache::remember('total_recipients', 300, function () {
            return PublicUser::count();
        });
    }

    /**
     * Get total initiatives count
     */
    private function getTotalInitiatives(): int
    {
        return Cache::remember('total_initiatives', 300, function () {
            return Initiative::count();
        });
    }

    /**
     * Get total amount from contributions
     */
    private function getTotalAmount(): float
    {
        return Cache::remember('total_amount', 300, function () {
            return Contribution::sum('amount') ?? 0;
        });
    }

    /**
     * Get category distribution for contributions
     */
    private function getCategoryDistribution(): array
    {
        return Contribution::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->category => $item->count];
            })
            ->toArray();
    }

    /**
     * Get monthly trend data for the last 12 months
     */
    private function getMonthlyTrend(): array
    {
        $monthlyData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M Y');
            
            $count = Contribution::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $monthlyData[] = [
                'month' => $month,
                'count' => $count
            ];
        }

        return $monthlyData;
    }

    /**
     * Get initiative applications by status
     */
    private function getApplicationStatus(): array
    {
        return InitiativeApplication::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            })
            ->toArray();
    }

    /**
     * Get recent initiatives for display
     */
    public function getRecentInitiatives(int $limit = 6): array
    {
        return Cache::remember("recent_initiatives_{$limit}", 300, function () use ($limit) {
            return Initiative::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($initiative) {
                    return [
                        'id' => $initiative->id,
                        'title' => $initiative->title,
                        'description' => $initiative->description,
                        'category' => $initiative->category,
                        'status' => $initiative->status,
                        'application_deadline' => $initiative->application_deadline ? Carbon::parse($initiative->application_deadline)->format('d M Y') : null,
                        'budget_amount' => $initiative->budget_amount,
                        'created_at' => $initiative->created_at->format('d M Y'),
                        'slug' => $initiative->slug,
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Clear statistics cache
     */
    public function clearCache(): void
    {
        $cacheKeys = [
            'dashboard_statistics',
            'chart_data',
            'recent_initiatives_6',
            'total_contributions',
            'total_recipients',
            'total_initiatives',
            'total_amount'
        ];

        // Clear Redis cache if available
        if ($this->redisCache->isRedisAvailable()) {
            $this->redisCache->clearCache($cacheKeys);
        }

        // Also clear default cache as fallback
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Get statistics for API endpoints
     */
    public function getStatisticsForApi(): array
    {
        return $this->getDashboardStatistics();
    }

    /**
     * Get chart data for API endpoints
     */
    public function getChartDataForApi(): array
    {
        return $this->getChartData();
    }

    /**
     * Get average contribution amount
     */
    private function getAverageContribution(): float
    {
        return Cache::remember('average_contribution', 300, function () {
            $totalAmount = Contribution::sum('amount') ?? 0;
            $totalContributions = Contribution::count();
            return $totalContributions > 0 ? round($totalAmount / $totalContributions, 2) : 0;
        });
    }

    /**
     * Get success rate (approved applications vs total)
     */
    private function getSuccessRate(): float
    {
        return Cache::remember('success_rate', 300, function () {
            $totalApplications = InitiativeApplication::count();
            $approvedApplications = InitiativeApplication::where('status', 'approved')->count();
            return $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 1) : 0;
        });
    }

    /**
     * Get recent activity (contributions in last 30 days)
     */
    private function getRecentActivity(): array
    {
        return Cache::remember('recent_activity', 300, function () {
            $last30Days = Contribution::where('created_at', '>=', Carbon::now()->subDays(30))->count();
            $last7Days = Contribution::where('created_at', '>=', Carbon::now()->subDays(7))->count();
            $today = Contribution::whereDate('created_at', Carbon::today())->count();
            
            return [
                'last_30_days' => $last30Days,
                'last_7_days' => $last7Days,
                'today' => $today
            ];
        });
    }

    /**
     * Get geographic distribution of contributions
     */
    private function getGeographicDistribution(): array
    {
        return Cache::remember('geographic_distribution', 300, function () {
            return Contribution::select('location', DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
                ->whereNotNull('location')
                ->groupBy('location')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'location' => $item->location,
                        'count' => $item->count,
                        'total_amount' => $item->total_amount
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get monthly growth percentage
     */
    private function getMonthlyGrowth(): float
    {
        return Cache::remember('monthly_growth', 300, function () {
            $currentMonth = Contribution::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();
            
            $lastMonth = Contribution::whereYear('created_at', Carbon::now()->subMonth()->year)
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->count();
            
            return $lastMonth > 0 ? round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1) : 0;
        });
    }

    /**
     * Get top contribution categories
     */
    private function getTopCategories(): array
    {
        return Cache::remember('top_categories', 300, function () {
            return Contribution::select('category', DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => $item->category,
                        'count' => $item->count,
                        'total_amount' => $item->total_amount
                    ];
                })
                ->toArray();
        });
    }
}
