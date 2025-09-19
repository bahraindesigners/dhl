<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('About Page Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Page Title')
                            ->required()
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Content')
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
                            ->columnSpanFull()
                            ->json(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Board Section')
                    ->schema([
                        Toggle::make('show_board_section')
                            ->label('Show Board Section')
                            ->reactive()
                            ->default(false),

                        TextInput::make('board_section_title')
                            ->label('Board Section Title')
                            ->visible(fn ($get) => $get('show_board_section'))
                            ->columnSpanFull(),

                        RichEditor::make('board_section_description')
                            ->label('Board Section Description')
                            ->visible(fn ($get) => $get('show_board_section'))
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
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
            ]);
    }
}
