<?php

namespace App\Filament\Resources\ComplaintSettings\Pages;

use App\Filament\Resources\ComplaintSettings\ComplaintSettingsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComplaintSettings extends ListRecords
{
    protected static string $resource = ComplaintSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
