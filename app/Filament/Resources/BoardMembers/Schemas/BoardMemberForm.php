<?php

namespace App\Filament\Resources\BoardMembers\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BoardMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 1,
                'lg' => 2,
                'xl' => 3,
            ])
            ->components([
                // Avatar Section - Prominent at top
                Section::make('Profile Photo')
                    ->description('Upload a professional headshot for the board member')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->label('')
                            ->collection('avatar')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->imageEditorMode(2)
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->maxSize(2048) // 2MB for better quality
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Upload a square photo (1:1 ratio). Recommended: 300x300px. Max size: 2MB')
                            ->alignCenter()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 1,
                    ])
                    ->icon('heroicon-o-camera')
                    ->compact(),

                // Basic Information Section
                Section::make('Basic Information')
                    ->description('Essential details about the board member')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user')
                            ->placeholder('Enter the board member\'s full name')
                            ->helperText('This will be displayed prominently on the website')
                            ->columnSpanFull(),

                        TextInput::make('position')
                            ->label('Position/Title')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-briefcase')
                            ->placeholder('e.g., Chairman, CEO, Board Member, Independent Director')
                            ->helperText('Official title or position within the organization')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 2,
                    ])
                    ->icon('heroicon-o-identification'),

                // Biography Section
                Section::make('About & Biography')
                    ->description('Detailed background information about the board member')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Biography')
                            ->placeholder('Provide a comprehensive biography including education, experience, achievements, and other relevant background information...')
                            ->helperText('Use the rich text editor to format the biography with headings, lists, bold text, and other formatting options.')
                            ->toolbarButtons([
                                'attachFiles',
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
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 3,
                    ])
                    ->icon('heroicon-o-document-text')
                    ->collapsible(),

                // Administrative Settings Section
                Section::make('Administrative Settings')
                    ->description('Display and status configuration')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Display Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->prefixIcon('heroicon-o-bars-3')
                                    ->placeholder('0')
                                    ->helperText('Lower numbers appear first in listings'),

                                Toggle::make('is_active')
                                    ->label('Active Status')
                                    ->default(true)
                                    ->helperText('Toggle to show/hide this board member on the website')
                                    ->inline(false),
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 3,
                    ])
                    ->icon('heroicon-o-cog-6-tooth')
                    ->compact(),
            ]);
    }
}
