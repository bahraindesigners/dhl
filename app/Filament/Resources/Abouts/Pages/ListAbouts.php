<?php

namespace App\Filament\Resources\Abouts\Pages;

use App\Filament\Resources\Abouts\AboutResource;
use App\Models\About;
use Filament\Resources\Pages\ListRecords;

class ListAbouts extends ListRecords
{
    protected static string $resource = AboutResource::class;

    public function mount(): void
    {
        // Redirect to edit the single About page instead of showing a list
        $about = About::getSingleInstance();
        $this->redirect(AboutResource::getUrl('edit', ['record' => $about]));
    }

    protected function getHeaderActions(): array
    {
        return [
            // No create action since we only allow one About page
        ];
    }
}
