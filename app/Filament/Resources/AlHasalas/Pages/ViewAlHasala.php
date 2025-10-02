<?php

namespace App\Filament\Resources\AlHasalas\Pages;

use App\Filament\Resources\AlHasalas\AlHasalaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlHasala extends ViewRecord
{
    protected static string $resource = AlHasalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
