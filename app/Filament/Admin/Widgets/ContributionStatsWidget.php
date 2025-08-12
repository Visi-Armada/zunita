<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Contribution;
use App\Models\Recipient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ContributionStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalContributions = Contribution::sum('amount');
        $totalRecipients = Recipient::count();
        $todayContributions = Contribution::whereDate('contribution_date', today())->sum('amount');
        $pendingContributions = Contribution::where('status', 'pending')->count();

        return [
            Stat::make('Total Contributions', 'RM ' . Number::format($totalContributions))
                ->description('All contributions to date')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
            
            Stat::make('Total Recipients', Number::format($totalRecipients))
                ->description('Unique beneficiaries')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
            
            Stat::make('Today\'s Contributions', 'RM ' . Number::format($todayContributions))
                ->description('Contributions made today')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('warning'),
            
            Stat::make('Pending Review', Number::format($pendingContributions))
                ->description('Contributions awaiting approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger'),
        ];
    }
}