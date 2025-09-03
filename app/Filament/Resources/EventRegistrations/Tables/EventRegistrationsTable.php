<?php

namespace App\Filament\Resources\EventRegistrations\Tables;

use App\Models\Event;
use App\Models\EventRegistration;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteBulkAction as TableDeleteBulkAction;
use Filament\Tables\Actions\EditAction as TableEditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\ActionGroup;


class EventRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                TextColumn::make('full_name')
                    ->label('Registrant')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name'])
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->weight('medium'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied to clipboard')
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->toggleable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                        'primary' => 'attended',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'confirmed',
                        'heroicon-o-x-circle' => 'cancelled',
                        'heroicon-o-check-badge' => 'attended',
                    ])
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'refunded',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'paid',
                        'heroicon-o-x-circle' => 'failed',
                        'heroicon-o-arrow-uturn-left' => 'refunded',
                    ]),

                TextColumn::make('amount_paid')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('USD')
                            ->label('Total Revenue'),
                    ]),

                TextColumn::make('registered_at')
                    ->label('Registered')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('confirmed_at')
                    ->label('Confirmed')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name')
                    ->label('User Account')
                    ->default('Guest Registration')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('special_requirements')
                    ->label('Special Requirements')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->special_requirements;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('registered_at', 'desc')
            ->groups([
                Group::make('event.title')
                    ->label('Event')
                    ->collapsible(),
                Group::make('status')
                    ->label('Status')
                    ->collapsible(),
                Group::make('payment_status')
                    ->label('Payment Status')
                    ->collapsible(),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Registration Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                    ])
                    ->native(false),

                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->native(false),

                Filter::make('has_user')
                    ->label('Has User Account')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('user_id')),

                Filter::make('guest_registration')
                    ->label('Guest Registration')
                    ->query(fn (Builder $query): Builder => $query->whereNull('user_id')),

                Filter::make('recent')
                    ->label('Recent (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('registered_at', '>=', now()->subDays(7))),
            ])
            ->recordActions([
                ActionGroup::make([Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'confirmed',
                            'confirmed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Registration confirmed')
                            ->success()
                            ->send();
                    }),

                Action::make('mark_attended')
                    ->label('Mark as Attended')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (EventRegistration $record) {
                        $record->update(['status' => 'attended']);
                        Notification::make()
                            ->title('Registration marked as attended')
                            ->success()
                            ->send();
                    }),

                EditAction::make()
                    ->icon('heroicon-o-pencil'),])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('confirm_selected')
                        ->label('Confirm Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'confirmed',
                                        'confirmed_at' => now(),
                                    ]);
                                }
                            });

                            Notification::make()
                                ->title('Selected registrations confirmed')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('mark_attended_selected')
                        ->label('Mark as Attended')
                        ->icon('heroicon-o-check-badge')
                        ->color('info')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if ($record->status === 'confirmed') {
                                    $record->update(['status' => 'attended']);
                                }
                            });

                            Notification::make()
                                ->title('Selected registrations marked as attended')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            
            ->emptyStateIcon('heroicon-o-user-group')
            ->emptyStateHeading('No registrations yet')
            ->emptyStateDescription('Once people start registering for events, their details will appear here.')
            ->striped();
    }
}
