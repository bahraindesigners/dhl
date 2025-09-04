<?php

namespace App\Filament\Resources\PermissionResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Permission Information')
                    ->description('Define permission name and assign to roles')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Permission Name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('Enter permission name (e.g., create-posts, edit-users)')
                                    ->helperText('Permission names should be descriptive and use kebab-case'),
                                    
                                TextInput::make('guard_name')
                                    ->label('Guard Name')
                                    ->default('web')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('The guard this permission applies to (usually "web")'),
                                    
                                Select::make('roles')
                                    ->label('Roles')
                                    ->multiple()
                                    ->relationship('roles', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull()
                                    ->helperText('Select which roles should have this permission')
                                    ->placeholder('Choose roles for this permission'),
                            ]),
                    ]),
            ]);
    }
}
