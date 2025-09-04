<?php

namespace App\Filament\Resources\HomeSliders\Pages;

use App\Filament\Resources\HomeSliders\HomeSliderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditHomeSlider extends EditRecord
{
    use Translatable;

    protected static string $resource = HomeSliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
