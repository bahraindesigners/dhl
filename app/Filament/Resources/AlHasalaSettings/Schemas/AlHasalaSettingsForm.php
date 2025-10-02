<?php

namespace App\Filament\Resources\AlHasalaSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AlHasalaSettingsForm
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
                    ->label('Maximum Al Hasala Duration')
                    ->helperText('Maximum number of months allowed for Al Hasala repayment'),
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
                    ->helperText('List of people who will receive notifications for new Al Hasala applications'),
                Toggle::make('is_active')
                    ->required()
                    ->label('Form Active')
                    ->helperText('When disabled, users cannot submit new Al Hasala applications'),
            ]);
    }
}
