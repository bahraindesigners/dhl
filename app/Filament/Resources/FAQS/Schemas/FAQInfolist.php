<?php

namespace App\Filament\Resources\FAQS\Schemas;

use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FAQInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ Details')
                    ->schema([
                        ViewField::make('question')
                            ->view('filament.components.text-display')
                            ->label('Question'),

                        ViewField::make('answer')
                            ->view('filament.components.markdown-display')
                            ->label('Answer'),

                        ViewField::make('category')
                            ->view('filament.components.badge-display')
                            ->label('Category'),

                        ViewField::make('status')
                            ->view('filament.components.status-display')
                            ->label('Status'),
                    ]),
            ]);
    }
}
