<?php

namespace App\Filament\Resources\AlHasalas\Pages;

use App\Filament\Resources\AlHasalas\AlHasalaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlHasalas extends ListRecords
{
    protected static string $resource = AlHasalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
