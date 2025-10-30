<?php

namespace App\Filament\Resources\UnionLoanSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnionLoanSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Loan Amount Settings')
                    ->description('Configure minimum and maximum loan amounts and monthly payment requirements')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextInput::make('min_amount')
                            ->required()
                            ->numeric()
                            ->prefix('BD')
                            ->minValue(1)
                            ->maxValue(50000)
                            ->step(0.01)
                            ->label('Minimum Loan Amount')
                            ->helperText('The smallest loan amount that can be requested'),
                        TextInput::make('max_amount')
                            ->required()
                            ->numeric()
                            ->prefix('BD')
                            ->minValue(1)
                            ->maxValue(100000)
                            ->step(0.01)
                            ->label('Maximum Loan Amount')
                            ->helperText('The largest loan amount that can be requested'),
                        TextInput::make('min_monthly_payment')
                            ->required()
                            ->numeric()
                            ->prefix('BD')
                            ->minValue(1)
                            ->maxValue(10000)
                            ->step(0.01)
                            ->label('Minimum Monthly Payment')
                            ->helperText('The minimum amount that must be paid monthly (affects maximum loan duration)'),
                    ])
                    ->columns(3),
                Section::make('Duration Settings')
                    ->description('Configure loan duration limits')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        TextInput::make('max_months')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(120)
                            ->suffix('months')
                            ->label('Maximum Loan Duration')
                            ->helperText('Maximum number of months allowed for loan repayment'),
                    ]),
                Section::make('Notification Settings')
                    ->description('Configure who receives loan application notifications')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Repeater::make('receivers')
                            ->label('Notification Recipients')
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->label('Email Address'),
                                TextInput::make('name')
                                    ->required()
                                    ->label('Name'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->columnSpanFull()
                            ->helperText('List of people who will receive notifications for new loan applications'),
                    ]),
                Section::make('System Settings')
                    ->description('Control system availability')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Toggle::make('is_active')
                            ->required()
                            ->label('Loan System Active')
                            ->helperText('When disabled, users cannot submit new loan applications'),
                    ]),
            ]);
    }
}
