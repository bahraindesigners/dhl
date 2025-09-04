<?php

namespace App\Filament\Resources\HomeSliders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HomeSlidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('desktop_image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('desktop_image', 'thumb'))
                    ->imageSize(60)
                    ->square()
                    ->defaultImageUrl(url('/logo.svg'))
                    ->extraImgAttributes([
                        'loading' => 'lazy',
                        'class' => 'object-cover rounded',
                    ]),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->wrap()
                    ->limit(40),

                TextColumn::make('subtitle')
                    ->searchable()
                    ->limit(50)
                    ->color('gray'),

                TextColumn::make('button_text')
                    ->label('Button')
                    ->badge()
                    ->color('primary'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('has_mobile_image')
                    ->label('Mobile Image')
                    ->getStateUsing(fn ($record) => $record->hasMobileImage())
                    ->boolean()
                    ->tooltip(fn ($record) => $record->hasMobileImage() ? 'Has mobile image' : 'Uses desktop image'),

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
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All sliders')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Filter::make('has_mobile_image')
                    ->label('Has Mobile Image')
                    ->query(fn (Builder $query): Builder => $query->whereHas('media', function ($q) {
                        $q->where('collection_name', 'mobile_image');
                    })),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }
}
