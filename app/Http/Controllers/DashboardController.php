<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\PublicUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        // McKinsey-grade analytics with comprehensive data structure
        
        // Total contributions with proper formatting
        $totalContributions = Contribution::where('status', 'approved')->sum('amount');
        
        // Total unique recipients
        $totalRecipients = PublicUser::count();
        
        // Active initiatives (distinct categories with recent activity)
        $activeInitiatives = Contribution::where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->distinct('category')
            ->count('category');
        
        // Monthly average (last 30 days)
        $monthlyAverage = Contribution::where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('amount');
        
        // Monthly trends for the last 6 months
        $monthlyData = Contribution::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $monthlyLabels = $monthlyData->map(function ($item) {
            return Carbon::parse($item->month . '-01')->format('M Y');
        })->toArray();
        
        $monthlyContributions = $monthlyData->pluck('total')->toArray();
        
        // Category breakdown
        $categoryBreakdown = Contribution::select('category', DB::raw('SUM(amount) as total'))
            ->where('status', 'approved')
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category')
            ->toArray();
        
        // Recent contributions with recipient details
        $recentContributions = Contribution::with('recipient')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($contribution) {
                return [
                    'date' => $contribution->created_at,
                    'recipient_name' => $contribution->recipient->name,
                    'category' => $contribution->category,
                    'amount' => $contribution->amount
                ];
            });
        
        // Impact data (beneficiaries by month)
        $impactData = Contribution::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(DISTINCT recipient_id) as beneficiaries')
        )
            ->where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $impactLabels = $impactData->map(function ($item) {
            return Carbon::parse($item->month . '-01')->format('M');
        })->toArray();
        
        $impactData = $impactData->pluck('beneficiaries')->toArray();
        
        // Geographic distribution (mock data for demo)
        $geographicData = [
            'Kuala Lumpur' => Contribution::where('status', 'approved')->where('location', 'like', '%Kuala Lumpur%')->sum('amount'),
            'Selangor' => Contribution::where('status', 'approved')->where('location', 'like', '%Selangor%')->sum('amount'),
            'Putrajaya' => Contribution::where('status', 'approved')->where('location', 'like', '%Putrajaya%')->sum('amount'),
            'Other' => Contribution::where('status', 'approved')->sum('amount') - 
                      Contribution::where('status', 'approved')->where('location', 'like', '%Kuala Lumpur%')->sum('amount') -
                      Contribution::where('status', 'approved')->where('location', 'like', '%Selangor%')->sum('amount') -
                      Contribution::where('status', 'approved')->where('location', 'like', '%Putrajaya%')->sum('amount')
        ];
        
        // Filter out zero values
        $geographicData = array_filter($geographicData);
        
        return response()->json([
            'totalContributions' => $totalContributions,
            'totalRecipients' => $totalRecipients,
            'activeInitiatives' => $activeInitiatives,
            'monthlyAverage' => $monthlyAverage,
            'monthlyLabels' => $monthlyLabels,
            'monthlyContributions' => $monthlyContributions,
            'categoryBreakdown' => $categoryBreakdown,
            'recentContributions' => $recentContributions,
            'impactLabels' => $impactLabels,
            'impactData' => $impactData,
            'geographicData' => $geographicData,
            'lastUpdated' => Carbon::now()->toISOString()
        ]);
    }

    public function getRealTimeStats()
    {
        // Real-time statistics for live updates
        $stats = [
            'totalContributions' => Contribution::where('status', 'approved')->sum('amount'),
            'totalRecipients' => Recipient::count(),
            'todayContributions' => Contribution::where('status', 'approved')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),
            'pendingReviews' => Contribution::where('status', 'pending')->count()
        ];

        return response()->json($stats);
    }
}