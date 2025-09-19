<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Message Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->columnSpan(1),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->columnSpan(1),

                        TextInput::make('subject')
                            ->label('Subject')
                            ->columnSpan(1),

                        Textarea::make('message')
                            ->label('Message')
                            ->rows(5)
                            ->columnSpanFull(),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled()
                            ->columnSpan(1),

                        TextInput::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->columnSpanFull(),

                        Toggle::make('is_read')
                            ->label('Mark as Read')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
