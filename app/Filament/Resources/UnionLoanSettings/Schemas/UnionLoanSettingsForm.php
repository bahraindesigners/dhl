<?php

namespace App\Filament\Resources\UnionLoanSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnionLoanSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('max_months')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->suffix('months')
                    ->label('Maximum Loan Duration')
                    ->helperText('Maximum number of months allowed for loan repayment'),
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
                Toggle::make('is_active')
                    ->required()
                    ->label('Form Active')
                    ->helperText('When disabled, users cannot submit new loan applications'),
            ]);
    }
}
