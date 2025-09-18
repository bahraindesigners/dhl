<?php

namespace App\Filament\Resources\FAQCategories\Pages;

use App\Filament\Resources\FAQCategories\FAQCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListFAQCategories extends ListRecords
{
    use Translatable;

    protected static string $resource = FAQCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
