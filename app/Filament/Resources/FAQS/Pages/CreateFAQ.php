<?php

namespace App\Filament\Resources\FAQS\Pages;

use App\Filament\Resources\FAQS\FAQResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateFAQ extends CreateRecord
{
    use Translatable;

    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
