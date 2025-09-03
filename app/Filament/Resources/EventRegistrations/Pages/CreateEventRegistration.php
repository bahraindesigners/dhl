<?php

namespace App\Filament\Resources\EventRegistrations\Pages;

use App\Filament\Resources\EventRegistrations\EventRegistrationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEventRegistration extends CreateRecord
{
    protected static string $resource = EventRegistrationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set registered_at to now if not provided
        if (empty($data['registered_at'])) {
            $data['registered_at'] = now();
        }

        // Auto-set confirmation date if status is confirmed
        if ($data['status'] === 'confirmed' && empty($data['confirmed_at'])) {
            $data['confirmed_at'] = now();
        }

        // Auto-set cancellation date if status is cancelled
        if ($data['status'] === 'cancelled' && empty($data['cancelled_at'])) {
            $data['cancelled_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
