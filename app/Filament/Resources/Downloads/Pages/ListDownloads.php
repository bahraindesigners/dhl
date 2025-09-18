<?php

namespace App\Filament\Resources\Downloads\Pages;

use App\Filament\Resources\Downloads\DownloadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListDownloads extends ListRecords
{
    // use Translatable;

    protected static string $resource = DownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
