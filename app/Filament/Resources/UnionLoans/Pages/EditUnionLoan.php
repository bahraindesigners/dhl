<?php

namespace App\Filament\Resources\UnionLoans\Pages;

use App\Filament\Resources\UnionLoans\UnionLoanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUnionLoan extends EditRecord
{
    protected static string $resource = UnionLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
