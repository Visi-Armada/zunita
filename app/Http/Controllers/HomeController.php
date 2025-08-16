<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Initiative;
use App\Models\PublicUser;
use App\Models\InitiativeApplication;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Get real statistics data
        $statistics = $this->getStatistics();
        
        // Get recent initiatives
        $recentInitiatives = Initiative::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get active carousel images
        $carousels = Carousel::active()->ordered()->take(6)->get();

        return view('home', compact('statistics', 'recentInitiatives', 'carousels'));
    }

    public function getStatistics()
    {
        // Total contributions
        $totalContributions = Contribution::count();
        
        // Total recipients
        $totalRecipients = PublicUser::count();
        
        // Total initiatives
        $totalInitiatives = Initiative::count();
        
        // Total amount (sum of all contributions)
        $totalAmount = Contribution::sum('amount');

        return [
            'contributions' => $totalContributions,
            'recipients' => $totalRecipients,
            'initiatives' => $totalInitiatives,
            'amount' => $totalAmount
        ];
    }

    public function getChartData()
    {
        // Category distribution for contributions
        $categoryData = Contribution::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->category => $item->count];
            });

        // Monthly trend data for the last 12 months
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

        // Initiative applications by status
        $applicationStatus = InitiativeApplication::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        return response()->json([
            'categoryData' => $categoryData,
            'monthlyData' => $monthlyData,
            'applicationStatus' => $applicationStatus
        ]);
    }

    public function getRecentInitiatives()
    {
        $initiatives = Initiative::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($initiative) {
                return [
                    'id' => $initiative->id,
                    'title' => $initiative->title,
                    'description' => $initiative->description,
                    'category' => $initiative->category,
                    'status' => $initiative->status,
                    'deadline' => $initiative->deadline ? Carbon::parse($initiative->deadline)->format('d M Y') : null,
                    'budget' => $initiative->budget,
                    'created_at' => $initiative->created_at->format('d M Y')
                ];
            });

        return response()->json($initiatives);
    }

    public function getStatisticsApi()
    {
        return response()->json($this->getStatistics());
    }
}
