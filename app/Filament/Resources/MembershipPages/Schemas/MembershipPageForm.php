<?php

namespace App\Filament\Resources\MembershipPages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MembershipPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Membership Information')
                    ->schema([
                        RichEditor::make('how_to_join')
                            ->label('How to Join the Union')
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

                        RichEditor::make('union_benefits')
                            ->label('Union Benefits')
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
                    ])
                    ->columns(1),

                Section::make('Member Form Settings')
                    ->schema([
                        Toggle::make('enable_member_form')
                            ->label('Enable Member Profile Form')
                            ->helperText('When enabled, users can submit their profile to join the union')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }
}
