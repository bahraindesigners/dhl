<?php

namespace App\Filament\Resources\MembershipPages\Pages;

use App\Filament\Resources\MembershipPages\MembershipPageResource;
use App\Models\MembershipPage;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;

class ManageMembershipPages extends ManageRecords
{
    protected static string $resource = MembershipPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Membership Page')
                ->url(fn (): string => $this->getResource()::getUrl('edit', ['record' => MembershipPage::getSingleton()]))
                ->icon('heroicon-o-pencil')
                ->visible(fn (): bool => MembershipPage::exists()),
        ];
    }

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return MembershipPage::query()->limit(1);
    }

    public function mount(): void
    {
        // Ensure at least one record exists
        MembershipPage::getSingleton();

        parent::mount();
    }
}
