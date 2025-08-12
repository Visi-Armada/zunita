<?php

namespace App\Filament\Admin\Resources\RecipientResource\Pages;

use App\Filament\Admin\Resources\RecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipients extends ListRecords
{
    protected static string $resource = RecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
