<?php

namespace App\Filament\Resources\BlogCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BlogCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'en') ?: $record->getTranslation('name', 'ar'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('description')
                    ->label('Description')
                    ->getStateUsing(fn ($record) => $record->getTranslation('description', 'en') ?: $record->getTranslation('description', 'ar'))
                    ->limit(50)
                    ->searchable(),
                
                TextColumn::make('color')
                    ->label('Color')
                    ->badge()
                    ->color(fn ($record) => $record->color),
                
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->searchable(),
                
                TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
