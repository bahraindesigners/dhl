<?php

namespace App\Filament\Resources\MembershipPages\Pages;

use App\Filament\Resources\MembershipPages\MembershipPageResource;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditMembershipPage extends EditRecord
{
    use Translatable;

    protected static string $resource = MembershipPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            // Remove delete action for singleton
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        // Stay on the same page after saving
        return null;
    }
}
