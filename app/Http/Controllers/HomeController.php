<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use App\Services\CarouselService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $statisticsService;
    protected $carouselService;

    public function __construct(StatisticsService $statisticsService, CarouselService $carouselService)
    {
        $this->statisticsService = $statisticsService;
        $this->carouselService = $carouselService;
    }

    public function index()
    {
        // Get data from services
        $statistics = $this->statisticsService->getDashboardStatistics();
        $recentInitiatives = $this->statisticsService->getRecentInitiatives();
        $carousels = $this->carouselService->getActiveCarousels();

        return view('home', compact('statistics', 'recentInitiatives', 'carousels'));
    }

    public function getChartData()
    {
        return response()->json($this->statisticsService->getChartDataForApi());
    }

    public function getRecentInitiatives()
    {
        return response()->json($this->statisticsService->getRecentInitiatives());
    }

    public function getStatisticsApi()
    {
        return response()->json($this->statisticsService->getStatisticsForApi());
    }
}
