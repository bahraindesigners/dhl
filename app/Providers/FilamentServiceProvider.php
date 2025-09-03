<?php

namespace App\Providers;

use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Configure Filament components to use public visibility by default
        FileUpload::configureUsing(fn (FileUpload $fileUpload) => $fileUpload
            ->disk('public')
            ->visibility('public'));

        ImageColumn::configureUsing(fn (ImageColumn $imageColumn) => $imageColumn
            ->disk('public')
            ->visibility('public'));
    }
}
