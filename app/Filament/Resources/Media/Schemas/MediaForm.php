<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Media Information')
                    ->description('Edit media file details and metadata')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('File Name')
                                    ->required()
                                    ->maxLength(255),
                                
                                TextInput::make('collection_name')
                                    ->label('Collection')
                                    ->maxLength(255)
                                    ->default('default'),
                            ]),
                        
                        Textarea::make('custom_properties.alt')
                            ->label('Alt Text')
                            ->placeholder('Descriptive text for accessibility')
                            ->maxLength(500),
                        
                        Textarea::make('custom_properties.description')
                            ->label('Description')
                            ->placeholder('Additional description or notes')
                            ->maxLength(1000),
                        
                        KeyValue::make('custom_properties')
                            ->label('Custom Properties')
                            ->addActionLabel('Add property')
                            ->keyLabel('Property name')
                            ->valueLabel('Property value')
                            ->reorderable(false),
                    ]),
                
                Section::make('File Details')
                    ->description('Read-only file information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('file_name')
                                    ->label('Original File Name')
                                    ->disabled(),
                                
                                TextInput::make('mime_type')
                                    ->label('MIME Type')
                                    ->disabled(),
                                
                                TextInput::make('size')
                                    ->label('File Size')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : null)
                                    ->disabled(),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                TextInput::make('disk')
                                    ->label('Storage Disk')
                                    ->disabled(),
                                
                                TextInput::make('created_at')
                                    ->label('Uploaded At')
                                    ->formatStateUsing(fn ($state) => $state?->format('M j, Y g:i A'))
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
