<?php

namespace App\Filament\Resources\FAQS\Pages;

use App\Filament\Resources\FAQS\FAQResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ViewFAQ extends ViewRecord
{
    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
        ];
    }
}
