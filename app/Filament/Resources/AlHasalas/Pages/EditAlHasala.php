<?php

namespace App\Filament\Resources\AlHasalas\Pages;

use App\Filament\Resources\AlHasalas\AlHasalaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlHasala extends EditRecord
{
    protected static string $resource = AlHasalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
