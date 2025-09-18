<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('About Page Information')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title (English)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('title', 'en')),

                        TextEntry::make('title_ar')
                            ->label('Title (Arabic)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('title', 'ar')),

                        TextEntry::make('content')
                            ->label('Content (English)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('content', 'en'))
                            ->html()
                            ->columnSpanFull(),

                        TextEntry::make('content_ar')
                            ->label('Content (Arabic)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('content', 'ar'))
                            ->html()
                            ->columnSpanFull(),

                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),

                        TextEntry::make('sort_order')
                            ->label('Sort Order')
                            ->numeric(),
                    ])
                    ->columns(2),

                Section::make('Board Section')
                    ->schema([
                        IconEntry::make('show_board_section')
                            ->label('Show Board Section')
                            ->boolean(),

                        TextEntry::make('board_section_title')
                            ->label('Board Section Title (English)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('board_section_title', 'en'))
                            ->visible(fn ($record) => $record->show_board_section),

                        TextEntry::make('board_section_title_ar')
                            ->label('Board Section Title (Arabic)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('board_section_title', 'ar'))
                            ->visible(fn ($record) => $record->show_board_section),

                        TextEntry::make('board_section_description')
                            ->label('Board Section Description (English)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('board_section_description', 'en'))
                            ->html()
                            ->visible(fn ($record) => $record->show_board_section)
                            ->columnSpanFull(),

                        TextEntry::make('board_section_description_ar')
                            ->label('Board Section Description (Arabic)')
                            ->getStateUsing(fn ($record) => $record->getTranslation('board_section_description', 'ar'))
                            ->html()
                            ->visible(fn ($record) => $record->show_board_section)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
