<?php

namespace App\Filament\Resources\AlHasalas\Tables;

use App\LoanStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AlHasalasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('BHD')
                    ->sortable(),
                TextColumn::make('months')
                    ->label('Duration')
                    ->numeric()
                    ->suffix(' months')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (LoanStatus $state): string => $state->color())
                    ->formatStateUsing(fn (LoanStatus $state): string => $state->label())
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Applied On')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        LoanStatus::Pending->value => LoanStatus::Pending->label(),
                        LoanStatus::Approved->value => LoanStatus::Approved->label(),
                        LoanStatus::Rejected->value => LoanStatus::Rejected->label(),
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
