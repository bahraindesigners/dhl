<?php

namespace App\Filament\Resources\UnionLoans\Schemas;

use App\LoanStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnionLoanForm
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
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('BD')
                    ->minValue(0)
                    ->maxValue(10000)
                    ->label('Loan Amount'),
                TextInput::make('months')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(60)
                    ->suffix('months')
                    ->label('Loan Duration'),
                Select::make('status')
                    ->options(LoanStatus::class)
                    ->default('pending')
                    ->required()
                    ->label('Status'),
                Textarea::make('note')
                    ->columnSpanFull()
                    ->rows(3)
                    ->label('Notes')
                    ->helperText('Any additional notes about the loan application'),
                Textarea::make('rejected_reason')
                    ->columnSpanFull()
                    ->rows(3)
                    ->label('Rejection Reason')
                    ->helperText('Reason for rejecting the loan (if applicable)')
                    ->visible(fn ($get) => $get('status') === 'rejected'),
            ]);
    }
}
