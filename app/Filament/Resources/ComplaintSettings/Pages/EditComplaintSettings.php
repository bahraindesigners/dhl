<?php

namespace App\Filament\Resources\ComplaintSettings\Pages;

use App\Filament\Resources\ComplaintSettings\ComplaintSettingsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditComplaintSettings extends EditRecord
{
    protected static string $resource = ComplaintSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
