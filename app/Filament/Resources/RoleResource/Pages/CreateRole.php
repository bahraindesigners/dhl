<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Extract permissions from data
        $permissions = $data['permissions'] ?? [];
        
        // Clean data (remove permissions from main data since we handle it separately)
        $cleanData = collect($data)->except(['permissions'])->toArray();

        // Create the role
        $role = Role::create($cleanData);

        // Sync permissions if any selected
        if (!empty($permissions)) {
            // Convert permission IDs to Permission models for Spatie
            $permissionModels = \Spatie\Permission\Models\Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($permissionModels);
        }

        return $role;
    }
}
