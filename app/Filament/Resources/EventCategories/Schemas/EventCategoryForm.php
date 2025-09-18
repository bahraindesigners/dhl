<?php

namespace App\Filament\Resources\EventCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 1,
                'lg' => 2,
            ])
            ->components([
                Section::make('Category Information')
                    ->description('Basic information about the event category')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Category Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 1,
                    ]),

                Section::make('Contact & Settings')
                    ->description('Email settings and category configuration')
                    ->schema([
                        TextInput::make('receiver_email')
                            ->label('Receiver Email')
                            ->email()
                            ->required()
                            ->helperText('Email address to receive notifications for events in this category')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Toggle::make('is_active')
                                    ->label('Active Status')
                                    ->default(true)
                                    ->helperText('Only active categories can be selected for events'),
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 1,
                    ]),
            ]);
    }
}
