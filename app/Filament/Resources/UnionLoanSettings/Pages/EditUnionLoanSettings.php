<?php

namespace App\Filament\Resources\UnionLoanSettings\Pages;

use App\Filament\Resources\UnionLoanSettings\UnionLoanSettingsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUnionLoanSettings extends EditRecord
{
    protected static string $resource = UnionLoanSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
