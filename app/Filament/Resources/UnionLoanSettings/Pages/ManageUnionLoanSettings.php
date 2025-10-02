<?php

namespace App\Filament\Resources\UnionLoanSettings\Pages;

use App\Filament\Resources\UnionLoanSettings\UnionLoanSettingsResource;
use App\Models\UnionLoanSettings;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;

class ManageUnionLoanSettings extends ManageRecords
{
    protected static string $resource = UnionLoanSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Loan Settings')
                ->url(fn (): string => $this->getResource()::getUrl('edit', ['record' => UnionLoanSettings::getSingleton()]))
                ->icon('heroicon-o-pencil')
                ->visible(fn (): bool => UnionLoanSettings::exists()),
        ];
    }

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return UnionLoanSettings::query()->limit(1);
    }

    public function mount(): void
    {
        // Ensure at least one record exists
        UnionLoanSettings::getSingleton();

        parent::mount();
    }
}