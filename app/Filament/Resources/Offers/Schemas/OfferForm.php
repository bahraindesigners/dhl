<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Offer Information')
                    ->description('Enter the basic information for this offer')
                    ->schema([
                        TextInput::make('title')
                            ->label('Offer Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('description')
                            ->label('Short Description')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('discount')
                            ->label('Discount')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('e.g., 50%, $25, Buy 1 Get 1')
                            ->columnSpan(1),

                        RichEditor::make('offer_description')
                            ->label('Detailed Offer Description')
                            ->required()
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->json()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Settings')
                    ->description('Configure offer settings and ordering')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive offers will not be visible to users'),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(2),
            ]);
    }
}
