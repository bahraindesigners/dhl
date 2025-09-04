<?php

namespace App\Filament\Resources\FAQS\Pages;

use App\Filament\Resources\FAQS\FAQResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditFAQ extends EditRecord
{
    use Translatable;

    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
