<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PageContent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Carbon\Carbon;

class PageOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSections = PageContent::count();
        $activeSections = PageContent::where('is_active', true)->count();
        $sectionsWithImages = PageContent::whereNotNull('images')->count();
        $lastUpdated = PageContent::max('updated_at');

        // Ensure we have a proper Carbon instance
        $lastUpdatedFormatted = 'Never';
        if ($lastUpdated) {
            $lastUpdatedCarbon = $lastUpdated instanceof Carbon ? $lastUpdated : Carbon::parse($lastUpdated);
            $lastUpdatedFormatted = $lastUpdatedCarbon->diffForHumans();
        }

        return [
            Stat::make('Total Sections', Number::format($totalSections))
                ->description('All content sections')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),
            
            Stat::make('Active Sections', Number::format($activeSections))
                ->description('Sections visible on website')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('Sections with Images', Number::format($sectionsWithImages))
                ->description('Sections containing images')
                ->descriptionIcon('heroicon-o-photo')
                ->color('warning'),
            
            Stat::make('Last Updated', $lastUpdatedFormatted)
                ->description('Most recent content change')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary'),
        ];
    }
}
