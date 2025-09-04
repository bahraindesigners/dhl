<?php

namespace App\Filament\Resources\HomeSliders\Pages;

use App\Filament\Resources\HomeSliders\HomeSliderResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateHomeSlider extends CreateRecord
{
    use Translatable;

    protected static string $resource = HomeSliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
