<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // DEBUG: Log all received data
        \Illuminate\Support\Facades\Log::info('EditRole handleRecordUpdate called with data:', [
            'data_keys' => array_keys($data),
            'has_permissions' => array_key_exists('permissions', $data),
            'permissions_value' => $data['permissions'] ?? 'NOT_SET',
            'permissions_type' => isset($data['permissions']) ? gettype($data['permissions']) : 'N/A',
            'permissions_count' => isset($data['permissions']) && is_array($data['permissions']) ? count($data['permissions']) : 0,
        ]);

        // VALIDATION: Stop update if permissions field is missing or empty
        if (!array_key_exists('permissions', $data)) {
            throw new \Exception('Permissions field is missing from form data. Cannot update role without permission information.');
        }

        if (!is_array($data['permissions'])) {
            throw new \Exception('Permissions field must be an array. Received: ' . gettype($data['permissions']));
        }

        // Extract permissions from data
        $permissions = $data['permissions'];
        
        // Clean data (remove permissions from main data since we handle it separately)
        $cleanData = collect($data)->except(['permissions'])->toArray();

        // Log what we're about to do
        \Illuminate\Support\Facades\Log::info('About to update role:', [
            'role_id' => $record->id,
            'clean_data' => $cleanData,
            'permissions_to_sync' => $permissions,
            'current_permissions_count' => $record->permissions()->count()
        ]);

        // Update the role basic data
        $record->update($cleanData);

        // Convert permission IDs to Permission models for Spatie
        $permissionModels = \Spatie\Permission\Models\Permission::whereIn('id', $permissions)->get();
        
        // Log the conversion
        \Illuminate\Support\Facades\Log::info('Converting permission IDs to models:', [
            'permission_ids' => $permissions,
            'found_permissions' => $permissionModels->pluck('name', 'id')->toArray()
        ]);

        // Sync permissions using Spatie's method with Permission models
        $record->syncPermissions($permissionModels);

        // Verify the update worked
        $record = $record->fresh();
        \Illuminate\Support\Facades\Log::info('Role updated successfully:', [
            'role_id' => $record->id,
            'final_permissions_count' => $record->permissions()->count(),
            'final_permissions' => $record->permissions()->pluck('name')->toArray()
        ]);

        return $record;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the role directly and load current permissions
        $role = Role::with('permissions')->find($this->record->getKey());
        
        if ($role) {
            $data['permissions'] = $role->permissions()->pluck('id')->toArray();
        }
        
        return $data;
    }
}
