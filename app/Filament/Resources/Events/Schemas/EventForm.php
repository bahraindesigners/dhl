<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Event Details')
                    ->tabs([
                        Tab::make('Content')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Event Title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $context, $state, callable $set) {
                                                if ($context === 'create') {
                                                    $set('slug', Str::slug($state));
                                                }
                                            })
                                            ->columnSpan(2),

                                        TextInput::make('slug')
                                            ->label('Event Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpan(2),
                                    ]),

                                Textarea::make('description')
                                    ->label('Short Description')
                                    ->rows(3)
                                    ->placeholder('Brief description of the event')
                                    ->columnSpanFull(),

                                RichEditor::make('content')
                                    ->label('Event Content')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',

                                        'blockquote',
                                        'codeBlock',
                                        'undo',
                                        'redo',
                                        'alignStart',
                                        'alignCenter',
                                        'alignEnd',
                                        'alignJustify',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Schedule & Location')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        DateTimePicker::make('start_date')
                                            ->label('Start Date & Time')
                                            ->required()
                                            ->seconds(false)
                                            ->native(false),

                                        DateTimePicker::make('end_date')
                                            ->label('End Date & Time')
                                            ->required()
                                            ->seconds(false)
                                            ->native(false)
                                            ->after('start_date'),
                                        DateTimePicker::make('published_at')
                                            ->label('Publish Date')
                                            ->seconds(false)
                                            ->native(false),

                                        Select::make('timezone')
                                            ->label('Timezone')
                                            ->options([
                                                'UTC' => 'UTC',
                                                'Asia/Kuwait' => 'Kuwait (UTC+3)',
                                                'Asia/Bahrain' => 'Bahrain (UTC+3)',
                                                'Asia/Dubai' => 'Dubai (UTC+4)',
                                                'Asia/Riyadh' => 'Riyadh (UTC+3)',
                                                'Europe/London' => 'London (UTC+0)',
                                                'America/New_York' => 'New York (UTC-5)',
                                            ])
                                            ->default('Asia/Kuwait')
                                            ->required(),

                                        Select::make('priority')
                                            ->label('Event Priority')
                                            ->options([
                                                'low' => 'Low',
                                                'medium' => 'Medium',
                                                'high' => 'High',
                                                'urgent' => 'Urgent',
                                            ])
                                            ->default('medium')
                                            ->required(),
                                    ]),

                                TextInput::make('location')
                                    ->label('Event Location')
                                    ->placeholder('e.g., Conference Center, Online, etc.')
                                    ->columnSpanFull(),

                                Textarea::make('location_details')
                                    ->label('Location Details')
                                    ->placeholder('Address, directions, room number, etc.')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Registration')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('registration_enabled')
                                            ->label('Enable Registration')
                                            ->default(true)
                                            ->live(),

                                        TextInput::make('capacity')
                                            ->label('Event Capacity')
                                            ->numeric()
                                            ->placeholder('Leave empty for unlimited'),

                                        TextInput::make('price')
                                            ->label('Registration Price')
                                            ->numeric()
                                            ->prefix('$')
                                            ->default(0.00)
                                            ->step(0.01),

                                        TextInput::make('registered_count')
                                            ->label('Current Registrations')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->dehydrated(false),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        DateTimePicker::make('registration_starts_at')
                                            ->label('Registration Opens')
                                            ->seconds(false)
                                            ->native(false)
                                            ->visible(fn (callable $get) => $get('registration_enabled')),

                                        DateTimePicker::make('registration_ends_at')
                                            ->label('Registration Closes')
                                            ->seconds(false)
                                            ->native(false)
                                            ->visible(fn (callable $get) => $get('registration_enabled')),
                                    ]),
                            ]),

                        Tab::make('Media')
                            ->schema([
                                Section::make('Featured Image')
                                    ->description('Main event image that will be displayed in listings and headers')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('featured_image')
                                            ->collection('featured_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->manipulations([
                                                'webp' => ['q' => 90],
                                                'resize' => [1200, 630],
                                            ])
                                            ->conversion('featured')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Event Gallery')
                                    ->description('Additional images for the event gallery')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->manipulations([
                                                'webp' => ['q' => 85],
                                                'resize' => [1200],
                                            ])
                                            ->conversion('high-quality')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Organizer & SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('organizer')
                                            ->label('Event Organizer')
                                            ->placeholder('Organization or company name')
                                            ->helperText('Use the language switcher to add translations'),

                                        TextInput::make('author')
                                            ->label('Content Author')
                                            ->placeholder('Author or team name')
                                            ->helperText('Use the language switcher to add translations')
                                            ->default(fn () => \Illuminate\Support\Facades\Auth::user()?->name),
                                    ]),

                                Textarea::make('organizer_details')
                                    ->label('Organizer Details')
                                    ->placeholder('Contact information, website, etc.')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->placeholder('Custom title for search engines')
                                            ->helperText('Recommended: 50-60 characters. Leave empty to use event title.')
                                            ->columnSpanFull(),

                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->placeholder('Description for search engines')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Recommended: 150-160 characters. Leave empty to use event description.')
                                            ->columnSpanFull(),

                                    ]),
                            ]),

                        Tab::make('Settings')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('status')
                                            ->label('Event Status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'cancelled' => 'Cancelled',
                                                'completed' => 'Completed',
                                            ])
                                            ->default('draft')
                                            ->required(),

                                        Toggle::make('featured')
                                            ->label('Featured Event')
                                            ->default(false),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
