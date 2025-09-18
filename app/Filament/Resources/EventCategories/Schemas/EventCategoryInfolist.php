<?php

namespace App\Filament\Resources\EventCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconSize;

class EventCategoryInfolist
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
                // Header Section - Category Info
                Section::make('Category Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('')
                            ->size('2xl')
                            ->weight(FontWeight::Bold)
                            ->alignCenter()
                            ->color('primary'),

                        TextEntry::make('description')
                            ->label('')
                            ->prose()
                            ->placeholder('No description available.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 2,
                    ])
                    ->compact(),

                // Contact & Settings Section
                Section::make('Contact & Settings')
                    ->description('Email and configuration details')
                    ->schema([
                        TextEntry::make('receiver_email')
                            ->label('Receiver Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email copied!')
                            ->copyMessageDuration(1500),

                        TextEntry::make('sort_order')
                            ->label('Sort Order')
                            ->icon('heroicon-o-list-bullet')
                            ->badge()
                            ->color('gray')
                            ->prefix('#'),

                        IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger')
                            ->size(IconSize::Large),

                        TextEntry::make('events_count')
                            ->label('Total Events')
                            ->state(fn ($record) => $record->events()->count())
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-calendar-days'),
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

                // Administrative Details
                Section::make('Administrative Details')
                    ->description('System information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime('F j, Y \a\t H:i')
                            ->icon('heroicon-o-calendar-days')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->since()
                            ->icon('heroicon-o-clock')
                            ->color('gray'),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                        'xl' => 3,
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->icon('heroicon-o-document-text'),
            ]);
    }
}
