<?php

namespace App\Filament\Resources\FAQS\Pages;

use App\Filament\Resources\FAQS\FAQResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ListFAQS extends ListRecords
{
    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
