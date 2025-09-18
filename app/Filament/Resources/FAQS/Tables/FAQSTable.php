<?php

namespace App\Filament\Resources\FAQS\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FAQSTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->wrap()
                    ->limit(60),

                TextColumn::make('faqCategory.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->getStateUsing(function ($record) {
                        return $record->faqCategory?->getTranslation('name', app()->getLocale())
                            ?: $record->faqCategory?->getTranslation('name', 'en')
                            ?: $record->category; // Fallback to legacy category
                    })
                    ->placeholder('No category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
                SelectFilter::make('faq_category_id')
                    ->label('Category')
                    ->options(function () {
                        return \App\Models\FAQCategory::active()
                            ->ordered()
                            ->get()
                            ->mapWithKeys(function ($category) {
                                $name = $category->getTranslation('name', app()->getLocale())
                                    ?: $category->getTranslation('name', 'en');

                                return [$category->id => $name];
                            });
                    })
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),

                Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->active())
                    ->label('Active Only'),

                Filter::make('featured')
                    ->query(fn (Builder $query): Builder => $query->featured())
                    ->label('Featured Only'),
            ])
            ->recordActions([
                // ViewAction::make(),
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
