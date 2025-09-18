<?php

namespace App\Filament\Resources\BoardMembers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconSize;
use Filament\Schemas\Components\Grid;

class BoardMemberInfolist
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
                // Header Section - Avatar and Basic Info
                Section::make()
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('avatar')
                            ->label('')
                            ->collection('avatar')
                            ->conversion('medium')
                            ->circular()
                            ->imageSize(180)
                            ->placeholder('/images/default-avatar.png'),
                        
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                            ->label('')
                            ->size('2xl')
                            ->weight(FontWeight::Bold)
                            ->alignCenter()
                            ->color('primary'),
                        
                        TextEntry::make('position')
                            ->label('')
                            ->size('lg')
                            ->alignCenter()
                            ->badge()
                            ->color('success')
                            ->icon('heroicon-o-briefcase'),
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 3,
                    ])
                    ->compact(),

                // Biography Section
                Section::make('About This Board Member')
                    ->description('Learn more about their background and expertise')
                    ->schema([
                        TextEntry::make('description')
                            ->label('')
                            ->html()
                            ->prose()
                            ->placeholder('No biography available at this time.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 2,
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->icon('heroicon-o-document-text'),

                // Status & Administrative Info
                Section::make('Administrative Details')
                    ->description('Status and management information')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Current Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger')
                            ->size(IconSize::Large),

                        TextEntry::make('sort_order')
                            ->label('Display Order')
                            ->icon('heroicon-o-list-bullet')
                            ->badge()
                            ->color('gray')
                            ->prefix('#')
                            ->suffix(' position'),

                        TextEntry::make('created_at')
                            ->label('Joined Board')
                            ->dateTime('F j, Y')
                            ->icon('heroicon-o-calendar-days')
                            ->color('gray')
                            ->tooltip('Date when this member was added to the board'),

                        TextEntry::make('updated_at')
                            ->label('Last Modified')
                            ->since()
                            ->icon('heroicon-o-clock')
                            ->color('gray')
                            ->tooltip('Last time this profile was updated'),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 1,
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->icon('heroicon-o-cog-6-tooth'),
            ]);
    }
}