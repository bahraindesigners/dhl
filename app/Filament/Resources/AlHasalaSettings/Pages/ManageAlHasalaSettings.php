<?php

namespace App\Filament\Resources\AlHasalaSettings\Pages;

use App\Filament\Resources\AlHasalaSettings\AlHasalaSettingsResource;
use App\Models\AlHasalaSettings;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;

class ManageAlHasalaSettings extends ManageRecords
{
    protected static string $resource = AlHasalaSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Al Hasala Settings')
                ->url(fn (): string => $this->getResource()::getUrl('edit', ['record' => AlHasalaSettings::getSingleton()]))
                ->icon('heroicon-o-pencil')
                ->visible(fn (): bool => AlHasalaSettings::exists()),
        ];
    }

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return AlHasalaSettings::query()->limit(1);
    }

    public function mount(): void
    {
        // Ensure at least one record exists
        AlHasalaSettings::getSingleton();

        parent::mount();
    }
}