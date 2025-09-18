<?php

namespace App\Filament\Resources\DownloadCategories\Pages;

use App\Filament\Resources\DownloadCategories\DownloadCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateDownloadCategory extends CreateRecord
{
    use Translatable;

    protected static string $resource = DownloadCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
