<?php

namespace App\Filament\Resources\UnionLoans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UnionLoanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('months')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
