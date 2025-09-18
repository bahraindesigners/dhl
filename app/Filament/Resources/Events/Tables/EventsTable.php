<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('featured_image'))
                    ->imageSize(50)
                    ->defaultImageUrl(url('/logo.svg'))
                    ->extraImgAttributes([
                        'loading' => 'lazy',
                        'class' => 'object-cover rounded',
                    ]),

                TextColumn::make('title')
                    ->label('Event Title')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'en') ?: $record->getTranslation('title', 'ar'))
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('medium'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'cancelled',
                        'primary' => 'completed',
                    ])
                    ->icons([
                        'heroicon-o-pencil' => 'draft',
                        'heroicon-o-eye' => 'published',
                        'heroicon-o-x-circle' => 'cancelled',
                        'heroicon-o-check-circle' => 'completed',
                    ]),

                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->colors([
                        'gray' => 'low',
                        'warning' => 'medium',
                        'success' => 'high',
                        'danger' => 'urgent',
                    ])
                    ->icons([
                        'heroicon-o-minus' => 'low',
                        'heroicon-o-exclamation-circle' => 'medium',
                        'heroicon-o-exclamation-triangle' => 'high',
                        'heroicon-o-bolt' => 'urgent',
                    ]),

                TextColumn::make('eventCategory.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->getStateUsing(function ($record) {
                        return $record->eventCategory?->getTranslation('name', app()->getLocale())
                            ?: $record->eventCategory?->getTranslation('name', 'en');
                    })
                    ->placeholder('No category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 30 ? $state : null;
                    })
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('registered_count')
                    ->label('Registrations')
                    ->formatStateUsing(function ($record) {
                        $current = $record->registered_count;
                        $capacity = $record->capacity;

                        return $capacity ? "{$current}/{$capacity}" : $current;
                    })
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('registration_enabled')
                    ->label('Registration')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('organizer')
                    ->label('Organizer')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('author')
                    ->label('Author')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),

                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low Priority',
                        'medium' => 'Medium Priority',
                        'high' => 'High Priority',
                        'urgent' => 'Urgent',
                    ]),

                SelectFilter::make('event_category_id')
                    ->label('Category')
                    ->options(function () {
                        return \App\Models\EventCategory::active()
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

                SelectFilter::make('featured')
                    ->options([
                        true => 'Featured',
                        false => 'Not Featured',
                    ])
                    ->label('Featured Status'),

                SelectFilter::make('registration_enabled')
                    ->options([
                        true => 'Registration Open',
                        false => 'Registration Closed',
                    ])
                    ->label('Registration Status'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
