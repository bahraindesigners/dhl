<?php

namespace App\Filament\Resources\HomeSliders\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class HomeSliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Home Slider Management')
                    ->tabs([
                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter slider title')
                                            ->columnSpanFull(),

                                        TextInput::make('subtitle')
                                            ->label('Subtitle')
                                            ->maxLength(500)
                                            ->placeholder('Enter slider subtitle')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->rows(4)
                                            ->maxLength(1000)
                                            ->placeholder('Enter slider description')
                                            ->columnSpanFull(),

                                        TextInput::make('button_text')
                                            ->label('Button Text')
                                            ->maxLength(100)
                                            ->placeholder('e.g., Learn More, Get Started'),

                                        TextInput::make('button_url')
                                            ->label('Button URL')
                                            ->url()
                                            ->maxLength(500)
                                            ->placeholder('/contact, /about, https://example.com'),
                                    ]),
                            ]),

                        Tab::make('Images')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Desktop Image')
                                    ->description('Main image for larger screens (Required)')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('desktop_image')
                                            ->collection('desktop_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['16:9', '21:9'])
                                            ->manipulations([
                                                'webp' => ['q' => 90],
                                            ])
                                            ->conversion('desktop_large')
                                            ->required()
                                            ->helperText('Recommended size: 1920x1080px or larger')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Mobile Image (Optional)')
                                    ->description('Specific image for mobile devices. If not provided, desktop image will be used.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('mobile_image')
                                            ->collection('mobile_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['9:16', '4:5', '3:4'])
                                            ->manipulations([
                                                'webp' => ['q' => 90],
                                            ])
                                            ->conversion('mobile_large')
                                            ->helperText('Recommended size: 768x1024px (portrait)')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true)
                                            ->helperText('Show this slider on the website'),

                                        TextInput::make('sort_order')
                                            ->label('Sort Order')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->helperText('Lower numbers appear first'),
                                    ]),
                            ]),
                    ]),
            ])->columns(1);
    }
}
