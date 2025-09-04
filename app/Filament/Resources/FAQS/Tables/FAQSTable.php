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

                TextColumn::make('category')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'gray',
                        'account' => 'blue',
                        'billing' => 'green',
                        'technical' => 'red',
                        'events' => 'purple',
                        'registration' => 'orange',
                        'payment' => 'yellow',
                        'support' => 'indigo',
                        default => 'gray',
                    }),

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
                SelectFilter::make('category')
                    ->options([
                        'general' => 'General',
                        'account' => 'Account',
                        'billing' => 'Billing',
                        'technical' => 'Technical',
                        'events' => 'Events',
                        'registration' => 'Registration',
                        'payment' => 'Payment',
                        'support' => 'Support',
                    ]),

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
