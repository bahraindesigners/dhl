<?php

namespace App\Filament\Resources\Downloads\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class DownloadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Download Management')
                    ->tabs([
                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter download title')
                                            ->helperText('The title will be displayed in the downloads list')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->rows(4)
                                            ->maxLength(1000)
                                            ->placeholder('Enter download description')
                                            ->helperText('Brief description of what this download contains')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('File Upload')
                            ->icon('heroicon-o-cloud-arrow-up')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('downloads')
                                    ->label('Download File')
                                    ->collection('downloads')
                                    ->required()
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                        'application/vnd.ms-powerpoint',
                                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                        'text/plain',
                                        'text/csv',
                                        'image/jpeg',
                                        'image/png',
                                        'image/gif',
                                        'image/webp',
                                        'application/zip',
                                        'application/x-rar-compressed',
                                    ])
                                    ->maxSize(50 * 1024) // 50MB max
                                    ->downloadable()
                                    ->previewable(false)
                                    ->helperText('Upload files up to 50MB. Supported formats: PDF, Word, Excel, PowerPoint, Images, Text, Archives')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('download_category_id')
                                            ->label('Category')
                                            ->relationship('downloadCategory', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                Textarea::make('description')
                                                    ->rows(3),
                                                TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255),
                                                Toggle::make('is_active')
                                                    ->default(true),
                                            ])
                                            ->placeholder('Select a category')
                                            ->helperText('Choose the most appropriate category'),

                                        Select::make('access_level')
                                            ->label('Access Level')
                                            ->options([
                                                'public' => 'Public Access',
                                                'employees' => 'Employees Only',
                                                'managers' => 'Managers Only',
                                                'admin' => 'Admin Only',
                                            ])
                                            ->required()
                                            ->default('employees')
                                            ->helperText('Who can access this download'),

                                        TextInput::make('sort_order')
                                            ->label('Display Order')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0)
                                            ->maxValue(999)
                                            ->helperText('Lower numbers appear first'),

                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true)
                                            ->helperText('Only active downloads are visible to users'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
