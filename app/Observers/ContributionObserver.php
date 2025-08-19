<?php

namespace App\Observers;

use App\Models\Contribution;
use App\Services\StatisticsService;

class ContributionObserver
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Handle the Contribution "created" event.
     */
    public function created(Contribution $contribution): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Contribution "updated" event.
     */
    public function updated(Contribution $contribution): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Contribution "deleted" event.
     */
    public function deleted(Contribution $contribution): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Contribution "restored" event.
     */
    public function restored(Contribution $contribution): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Contribution "force deleted" event.
     */
    public function forceDeleted(Contribution $contribution): void
    {
        $this->clearCache();
    }

    /**
     * Clear relevant cache
     */
    private function clearCache(): void
    {
        $this->statisticsService->clearCache();
    }
}
