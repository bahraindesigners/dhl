<?php

namespace App\Filament\Resources\DownloadCategories\Pages;

use App\Filament\Resources\DownloadCategories\DownloadCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditDownloadCategory extends EditRecord
{
    use Translatable;

    protected static string $resource = DownloadCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
