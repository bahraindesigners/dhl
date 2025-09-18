<?php

namespace App\Filament\Resources\DownloadCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DownloadCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->description('Basic information about this download category')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Category Name')
                                    ->getStateUsing(fn ($record) => $record->getTranslation('name', app()->getLocale())
                                        ?: $record->getTranslation('name', 'en'))
                                    ->weight('medium'),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->getStateUsing(fn ($record) => $record->getTranslation('description', app()->getLocale())
                                        ?: $record->getTranslation('description', 'en'))
                                    ->placeholder('No description provided'),
                            ]),
                    ]),

                Section::make('Settings')
                    ->description('Category configuration and status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('slug')
                                    ->label('Slug')
                                    ->badge()
                                    ->color('gray')
                                    ->copyable()
                                    ->copyMessage('Slug copied to clipboard')
                                    ->copyMessageDuration(1500),

                                TextEntry::make('sort_order')
                                    ->label('Sort Order')
                                    ->badge()
                                    ->color('info')
                                    ->formatStateUsing(fn ($state) => "#{$state}"),

                                IconEntry::make('is_active')
                                    ->label('Status')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-badge')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),
                    ]),

                Section::make('Statistics')
                    ->description('Usage statistics and metadata')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('downloads_count')
                                    ->state(fn ($record) => $record->downloads()->count())
                                    ->label('Total Downloads')
                                    ->badge()
                                    ->color('primary')
                                    ->formatStateUsing(fn ($state) => $state.' downloads'),

                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('M j, Y g:i A')
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('M j, Y g:i A')
                                    ->color('gray'),
                            ]),
                    ]),
            ]);
    }
}
