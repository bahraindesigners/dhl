<?php

namespace App\Filament\Resources\UnionLoans\Pages;

use App\Filament\Resources\UnionLoans\UnionLoanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnionLoans extends ListRecords
{
    protected static string $resource = UnionLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
