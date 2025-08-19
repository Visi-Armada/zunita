<?php

namespace App\Filament\Admin\Resources\InitiativeApplicationResource\Pages;

use App\Filament\Admin\Resources\InitiativeApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInitiativeApplications extends ListRecords
{
    protected static string $resource = InitiativeApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
