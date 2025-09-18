<?php

namespace App\Filament\Resources\DownloadCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DownloadCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Category Name')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', app()->getLocale())
                        ?: $record->getTranslation('name', 'en'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                TextColumn::make('description')
                    ->label('Description')
                    ->getStateUsing(fn ($record) => $record->getTranslation('description', app()->getLocale())
                        ?: $record->getTranslation('description', 'en'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state ?? '') > 50 ? $state : null;
                    })
                    ->toggleable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('downloads_count')
                    ->counts('downloads')
                    ->label('Downloads')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Sort Order')
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->boolean()
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
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
                    ])
                    ->default(true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }
}
