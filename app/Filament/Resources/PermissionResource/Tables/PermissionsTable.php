<?php

namespace App\Filament\Resources\PermissionResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Permission Name')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('roles_count')
                    ->label('Roles')
                    ->counts('roles')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('users_count')
                    ->label('Direct Users')
                    ->counts('users')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
