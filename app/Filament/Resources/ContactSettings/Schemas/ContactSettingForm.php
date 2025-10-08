<?php

namespace App\Filament\Resources\ContactSettings\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Contact Information')
                    ->schema([
                        TagsInput::make('notification_emails')
                            ->label('Notification Emails')
                            ->placeholder('Add email addresses')
                            ->helperText('Enter email addresses where contact form submissions will be sent. Press Enter after each email.')
                            ->nestedRecursiveRules([
                                'email',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Social Media Links')
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/dhlunion')
                            ->columnSpan(1),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->placeholder('https://linkedin.com/company/dhlunion')
                            ->columnSpan(1),

                        TextInput::make('x_url')
                            ->label('X (Twitter) URL')
                            ->url()
                            ->placeholder('https://x.com/dhlunion')
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Office Information')
                    ->schema([
                        TextInput::make('office_address')
                            ->label('Office Address')
                            ->placeholder('DHL Bahrain, Building 123, Industrial Area, Manama')
                            ->columnSpanFull(),

                        TextInput::make('phone_numbers')
                            ->label('Phone Numbers')
                            ->placeholder('+973 1234 5678')
                            ->columnSpanFull(),

                        TextInput::make('office_hours')
                            ->label('Office Hours')
                            ->placeholder('Sunday - Thursday: 8:00 AM - 5:00 PM')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Additional Content')
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
            ]);
    }
}
