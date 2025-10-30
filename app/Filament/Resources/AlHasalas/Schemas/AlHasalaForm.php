<?php

namespace App\Filament\Resources\AlHasalas\Schemas;

use App\LoanStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlHasalaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Member'),
                TextInput::make('monthly_amount')
                    ->required()
                    ->numeric()
                    ->prefix('BD')
                    ->minValue(0)
                    ->maxValue(10000)
                    ->label('Monthly Savings Amount')
                    ->helperText('The amount to be saved monthly')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $months = $get('months');
                        if ($state && $months) {
                            $set('total_amount', $state * $months);
                        }
                    }),
                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('BD')
                    ->disabled()
                    ->dehydrated(false)
                    ->label('Total Amount at End')
                    ->helperText('Calculated as: Monthly Amount × Duration')
                    ->default(fn(callable $get) => ($get('monthly_amount') ?? 0) * ($get('months') ?? 0)),
                TextInput::make('months')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(60)
                    ->suffix('months')
                    ->label('Savings Duration')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $monthlyAmount = $get('monthly_amount');
                        if ($state && $monthlyAmount) {
                            $set('total_amount', $monthlyAmount * $state);
                        }
                    }),
                Select::make('status')
                    ->options(LoanStatus::class)
                    ->default('pending')
                    ->required()
                    ->label('Status'),
                Textarea::make('note')
                    ->columnSpanFull()
                    ->rows(3)
                    ->label('Notes')
                    ->helperText('Any additional notes about the Al Hasala application'),
                Textarea::make('rejected_reason')
                    ->columnSpanFull()
                    ->rows(3)
                    ->label('Rejection Reason')
                    ->helperText('Fill this field only when status is set to rejected')
                    ->nullable(),
            ]);
    }
}
