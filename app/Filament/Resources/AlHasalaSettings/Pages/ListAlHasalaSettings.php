<?php

namespace App\Filament\Resources\AlHasalaSettings\Pages;

use App\Filament\Resources\AlHasalaSettings\AlHasalaSettingsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlHasalaSettings extends ListRecords
{
    protected static string $resource = AlHasalaSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
