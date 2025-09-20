<?php

namespace App\Filament\Resources\UnionLoans\Pages;

use App\Filament\Resources\UnionLoans\UnionLoanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnionLoan extends ViewRecord
{
    protected static string $resource = UnionLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
