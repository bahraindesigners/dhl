<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Text;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Text::make('Posts use the Spatie Media Library for file uploads.'),
                Text::make('This is a demonstration model to show how media library integration works.'),
            ]);
    }
}
