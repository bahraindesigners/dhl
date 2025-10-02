<?php

namespace App\Filament\Resources\ComplaintSettings\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ComplaintSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('form_enabled')
                    ->label('Enable Complaint Form')
                    ->helperText('Enable or disable the complaint submission form for members')
                    ->default(true),

                TagsInput::make('admin_emails')
                    ->label('Admin Email Addresses')
                    ->helperText('List of email addresses that will receive notifications about new complaints')
                    ->placeholder('Enter email addresses and press Enter')
                    ->columnSpanFull(),
            ]);
    }
}
