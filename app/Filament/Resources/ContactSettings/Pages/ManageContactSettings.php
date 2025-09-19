<?php

namespace App\Filament\Resources\ContactSettings\Pages;

use App\Filament\Resources\ContactSettings\ContactSettingResource;
use App\Models\ContactSetting;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;

class ManageContactSettings extends ManageRecords
{
    protected static string $resource = ContactSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Contact Settings')
                ->url(fn (): string => $this->getResource()::getUrl('edit', ['record' => ContactSetting::getSingleton()]))
                ->icon('heroicon-o-pencil')
                ->visible(fn (): bool => ContactSetting::exists()),
        ];
    }

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return ContactSetting::query()->limit(1);
    }

    public function mount(): void
    {
        // Ensure at least one record exists
        ContactSetting::getSingleton();

        parent::mount();
    }
}
