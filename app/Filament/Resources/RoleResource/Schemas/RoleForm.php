<?php

namespace App\Filament\Resources\RoleResource\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Role Information')
                ->description('Define role name')
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label('Role Name')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->placeholder('Enter role name (e.g., Editor, Manager)')
                        ->helperText('Role names should be descriptive and unique'),
                ]),

            Section::make('Permissions')
                ->description('Select the permissions for this role')
                ->columnSpanFull()
                ->schema([
                    CheckboxList::make('permissions')
                        ->label('Role Permissions')
                        ->options(Permission::all()->pluck('name', 'id'))
                        ->columns(3)
                        ->searchable()
                        ->bulkToggleable()
                        ->required(false)
                        ->helperText('Select the permissions this role should have'),
                ])
        ]);
    }
}
