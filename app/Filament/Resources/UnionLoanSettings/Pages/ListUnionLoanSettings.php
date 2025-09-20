<?php

namespace App\Filament\Resources\UnionLoanSettings\Pages;

use App\Filament\Resources\UnionLoanSettings\UnionLoanSettingsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnionLoanSettings extends ListRecords
{
    protected static string $resource = UnionLoanSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
