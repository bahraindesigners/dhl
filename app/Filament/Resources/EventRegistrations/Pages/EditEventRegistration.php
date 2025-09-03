<?php

namespace App\Filament\Resources\EventRegistrations\Pages;

use App\Filament\Resources\EventRegistrations\EventRegistrationResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEventRegistration extends EditRecord
{
    protected static string $resource = EventRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->label('Confirm Registration')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status !== 'confirmed')
                ->action(function () {
                    $this->record->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Registration Confirmed')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status', 'confirmed_at']);
                }),

            Action::make('cancel')
                ->label('Cancel Registration')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => !in_array($this->record->status, ['cancelled', 'attended']))
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Registration Cancelled')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status', 'cancelled_at']);
                }),

            Action::make('mark_attended')
                ->label('Mark as Attended')
                ->icon('heroicon-o-check-badge')
                ->color('info')
                ->visible(fn () => $this->record->status === 'confirmed')
                ->action(function () {
                    $this->record->update([
                        'status' => 'attended',
                    ]);

                    Notification::make()
                        ->title('Marked as Attended')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),

            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-set confirmation date if status changed to confirmed
        if ($data['status'] === 'confirmed' && $this->record->status !== 'confirmed' && empty($data['confirmed_at'])) {
            $data['confirmed_at'] = now();
        }

        // Auto-set cancellation date if status changed to cancelled
        if ($data['status'] === 'cancelled' && $this->record->status !== 'cancelled' && empty($data['cancelled_at'])) {
            $data['cancelled_at'] = now();
        }

        // Clear confirmation date if status is no longer confirmed
        if ($data['status'] !== 'confirmed' && $this->record->status === 'confirmed') {
            $data['confirmed_at'] = null;
        }

        // Clear cancellation date if status is no longer cancelled
        if ($data['status'] !== 'cancelled' && $this->record->status === 'cancelled') {
            $data['cancelled_at'] = null;
        }

        return $data;
    }
}
