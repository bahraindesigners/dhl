<?php

namespace App\Filament\Resources\ComplaintSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComplaintSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('form_enabled')
                    ->label('Form Enabled')
                    ->boolean(),

                IconColumn::make('email_notifications_enabled')
                    ->label('Email Notifications')
                    ->boolean(),

                TextColumn::make('admin_emails')
                    ->label('Admin Emails')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state) && ! empty($state)) {
                            return collect($state)->pluck('email')->join(', ');
                        }

                        return 'No emails configured';
                    })
                    ->limit(50),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
