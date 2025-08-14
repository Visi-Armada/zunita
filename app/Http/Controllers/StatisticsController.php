<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\ContributionRequest;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function index()
    {
        $stats = $this->getAnonymizedStatistics();
        
        return view('public.statistics.index', [
            'statistics' => $stats,
            'categories' => $this->getCategories(),
            'timeRanges' => $this->getTimeRanges(),
        ]);
    }

    public function data(Request $request)
    {
        $type = $request->get('type', 'overview');
        $period = $request->get('period', 'monthly');
        $category = $request->get('category', 'all');
        
        return response()->json(
            $this->getChartData($type, $period, $category)
        );
    }

    public function download(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $data = $this->getAnonymizedStatistics();
        
        if ($format === 'excel') {
            return $this->downloadExcel($data);
        }
        
        return $this->downloadPDF($data);
    }

    private function getAnonymizedStatistics()
    {
        $contributions = Contribution::query()
            ->where('status', 'approved')
            ->get()
            ->map(function ($contribution) {
                return [
                    'amount' => $contribution->amount,
                    'category' => $contribution->category,
                    'date' => $contribution->created_at,
                    'location' => $this->anonymizeLocation($contribution->location),
                ];
            });

        return [
            'total_contributions' => $contributions->sum('amount'),
            'total_recipients' => $contributions->unique('location')->count(),
            'total_transactions' => $contributions->count(),
            'monthly_average' => $contributions->groupBy(function ($item) {
                return $item['date']->format('Y-m');
            })->map->sum('amount')->avg(),
            'category_breakdown' => $contributions->groupBy('category')
                ->map->sum('amount')
                ->sortByDesc(null),
            'monthly_trend' => $contributions->groupBy(function ($item) {
                return $item['date']->format('Y-m');
            })->map->sum('amount'),
            'geographic_distribution' => $contributions->groupBy('location')
                ->map->sum('amount')
                ->sortByDesc(null)
                ->take(10),
        ];
    }

    private function getChartData($type, $period, $category)
    {
        $query = Contribution::query()->where('status', 'approved');
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        switch ($type) {
            case 'monthly':
                return $this->getMonthlyData($query, $period);
            case 'category':
                return $this->getCategoryData($query);
            case 'location':
                return $this->getLocationData($query);
            default:
                return $this->getOverviewData($query);
        }
    }

    private function getMonthlyData($query, $period)
    {
        $months = $period === 'yearly' ? 12 : 6;
        
        $data = $query->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths($months))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return [
            'labels' => $data->pluck('month')->map(function ($month) {
                return Carbon::parse($month)->format('M Y');
            }),
            'values' => $data->pluck('total'),
            'counts' => $data->pluck('count'),
        ];
    }

    private function getCategoryData($query)
    {
        $data = $query->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'labels' => $data->pluck('category'),
            'values' => $data->pluck('total'),
        ];
    }

    private function getLocationData($query)
    {
        $data = $query->select('location', DB::raw('SUM(amount) as total'))
            ->groupBy('location')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'location' => $this->anonymizeLocation($item->location),
                    'total' => $item->total,
                ];
            });

        return [
            'labels' => $data->pluck('location'),
            'values' => $data->pluck('total'),
        ];
    }

    private function getOverviewData($query)
    {
        return [
            'total_amount' => $query->sum('amount'),
            'total_transactions' => $query->count(),
            'average_amount' => $query->avg('amount'),
            'categories' => $query->distinct()->pluck('category'),
        ];
    }

    private function anonymizeLocation($location)
    {
        if (!$location) return 'Unknown';
        
        // Anonymize to district level
        $parts = explode(',', $location);
        return trim($parts[0] ?? 'Unknown');
    }

    private function getCategories()
    {
        return Contribution::distinct()->pluck('category')->filter();
    }

    private function getTimeRanges()
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ];
    }

    private function downloadExcel($data)
    {
        // Placeholder for Excel export
        return response()->json(['message' => 'Excel export coming soon']);
    }

    private function downloadPDF($data)
    {
        // Placeholder for PDF export
        return response()->json(['message' => 'PDF export coming soon']);
    }
}