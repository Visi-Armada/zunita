<?php

namespace App\Services;

use App\Models\Contribution;
use App\Models\Initiative;
use App\Models\PublicUser;
use App\Models\InitiativeApplication;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class StatisticsService
{
    /**
     * Get dashboard statistics
     */
    public function getDashboardStatistics(): array
    {
        return Cache::remember('dashboard_statistics', 600, function () { // Increased cache time to 10 minutes
            return [
                'contributions' => $this->getTotalContributions(),
                'recipients' => $this->getTotalRecipients(),
                'initiatives' => $this->getTotalInitiatives(),
                'amount' => $this->getTotalAmount(),
            ];
        });
    }

    /**
     * Get chart data for the dashboard
     */
    public function getChartData(): array
    {
        return Cache::remember('chart_data', 600, function () { // Increased cache time to 10 minutes
            return [
                'categoryData' => $this->getCategoryDistribution(),
                'monthlyData' => $this->getMonthlyTrend(),
                'applicationStatus' => $this->getApplicationStatus(),
            ];
        });
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
        Cache::forget('dashboard_statistics');
        Cache::forget('chart_data');
        Cache::forget('recent_initiatives_6');
        Cache::forget('total_contributions');
        Cache::forget('total_recipients');
        Cache::forget('total_initiatives');
        Cache::forget('total_amount');
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
}
