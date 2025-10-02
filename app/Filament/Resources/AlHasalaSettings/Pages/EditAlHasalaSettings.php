<?php

namespace App\Filament\Resources\AlHasalaSettings\Pages;

use App\Filament\Resources\AlHasalaSettings\AlHasalaSettingsResource;
use Filament\Resources\Pages\EditRecord;

class EditAlHasalaSettings extends EditRecord
{
    protected static string $resource = AlHasalaSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Remove delete action for singleton settings
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        // Stay on the same page after saving
        return null;
    }
}
