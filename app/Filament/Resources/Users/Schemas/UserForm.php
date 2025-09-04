<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->description('Basic user account details')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter full name'),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('user@example.com'),
                            ])
                            ->columns(2),
                    ]),

                Section::make('Password & Security')
                    ->description('Password and account verification settings')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required(fn(string $context): bool => $context === 'create')
                                    ->rule(Password::default())
                                    ->dehydrateStateUsing(
                                        fn(?string $state): ?string => filled($state) ? Hash::make($state) : null
                                    )
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->placeholder('Enter password')
                                    ->helperText('Leave empty to keep current password when editing'),

                                TextInput::make('password_confirmation')
                                    ->label('Confirm Password')
                                    ->password()
                                    ->required(fn(string $context): bool => $context === 'create')
                                    ->same('password')
                                    ->dehydrated(false)
                                    ->placeholder('Confirm password'),

                                DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->nullable()
                                    ->helperText('Set to mark email as verified'),
                                Select::make('roles')
                                    ->label(__('Role Name'))
                                    ->placeholder(__('Select roles'))
                                    ->default(fn($record) => $record ? $record->roles->pluck('id', 'name')->toArray() : [])
                                    ->multiple()
                                    ->relationship('roles', 'name'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
