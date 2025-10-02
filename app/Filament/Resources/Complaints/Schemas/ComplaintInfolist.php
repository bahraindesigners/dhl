<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ticket_id'),
                TextEntry::make('user.name'),
                TextEntry::make('memberProfile.id'),
                TextEntry::make('subject'),
                TextEntry::make('status'),
                TextEntry::make('priority'),
                TextEntry::make('resolved_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
