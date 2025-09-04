<?php

namespace Database\Seeders;

use Hexters\HexaLite\Models\HexaRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Dynamic Permission Seeder for HexaLite
 *
 * This seeder automatically generates permissions based on available models in the app/Models directory.
 * It creates four roles with different access levels:
 *
 * - Super Admin: Full access to all models and system features
 * - Admin: Full access to content models, limited user management, no role management
 * - Editor: Create/edit content, limited delete permissions, no user/role management
 * - User: Read-only access to selected models only
 *
 * Features:
 * - Automatically scans app/Models directory for Eloquent models
 * - Generates standard CRUD permissions for each model (index, create, update, delete, etc.)
 * - Supports model-specific permission customization
 * - Handles special cases like BlogCategory -> category permissions
 * - Includes system permissions (dashboard, settings)
 * - Automatically includes new models when they are added
 *
 * Usage:
 * php artisan db:seed --class=HexaPermissionSeeder
 */
class HexaPermissionSeeder extends Seeder
{
    /**
     * Standard permissions for each model
     */
    private const PERMISSIONS = [
        'index',
        'create',
        'update',
        'delete',
        'restore',
        'replicate',
        'reorder',
        'force_delete',
    ];

    /**
     * Additional system permissions
     */
    private const SYSTEM_PERMISSIONS = [
        'dashboard.index',
        'settings.index',
        'settings.update',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles with dynamically generated permissions
        $this->createSuperAdminRole();
        $this->createAdminRole();
        $this->createEditorRole();
        $this->createUserRole();
    }

    /**
     * Get all model names from the Models directory
     */
    private function getAvailableModels(): array
    {
        $modelsPath = app_path('Models');
        $models = [];

        if (File::exists($modelsPath)) {
            $files = File::files($modelsPath);

            foreach ($files as $file) {
                $className = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Skip non-model files or specific models we don't want to include
                if ($this->shouldIncludeModel($className)) {
                    $models[] = Str::snake($className);
                }
            }
        }

        return $models;
    }

    /**
     * Determine if a model should be included in permissions
     */
    private function shouldIncludeModel(string $className): bool
    {
        // Skip abstract models, traits, or specific models
        $excludedModels = ['User']; // User has special handling

        return ! in_array($className, $excludedModels) &&
               ! Str::endsWith($className, 'Trait') &&
               ! Str::startsWith($className, 'Abstract');
    }

    /**
     * Generate permissions array for given models and access levels
     */
    private function generatePermissions(array $models, array $accessLevels): array
    {
        $permissions = [];

        // Add system permissions
        if (isset($accessLevels['system'])) {
            if (is_array($accessLevels['system'])) {
                foreach ($accessLevels['system'] as $permission => $value) {
                    $permissions[$permission] = $value;
                }
            } else {
                foreach (self::SYSTEM_PERMISSIONS as $permission) {
                    $permissions[$permission] = $accessLevels['system'];
                }
            }
        }

        // Add user management permissions (special case)
        foreach (self::PERMISSIONS as $action) {
            if (is_array($accessLevels['user'])) {
                $permissions["user.{$action}"] = $accessLevels['user'][$action] ?? false;
            } else {
                $permissions["user.{$action}"] = $accessLevels['user'] ?? false;
            }
        }

        // Add role management permissions (special case)
        foreach (self::PERMISSIONS as $action) {
            if (is_array($accessLevels['role'])) {
                $permissions["role.{$action}"] = $accessLevels['role'][$action] ?? false;
            } else {
                $permissions["role.{$action}"] = $accessLevels['role'] ?? false;
            }
        }

        // Add dynamic model permissions
        foreach ($models as $model) {
            $modelKey = $this->getModelKey($model);
            $modelAccess = $accessLevels['models'][$modelKey] ?? $accessLevels['default'] ?? false;

            foreach (self::PERMISSIONS as $action) {
                if (is_array($modelAccess)) {
                    $permissions["{$modelKey}.{$action}"] = $modelAccess[$action] ?? false;
                } else {
                    $permissions["{$modelKey}.{$action}"] = $modelAccess;
                }
            }
        }

        // Add media permissions (special case for Filament media)
        foreach (self::PERMISSIONS as $action) {
            if (is_array($accessLevels['media'])) {
                $permissions["media.{$action}"] = $accessLevels['media'][$action] ?? false;
            } else {
                $permissions["media.{$action}"] = $accessLevels['media'] ?? false;
            }
        }

        return $permissions;
    }

    /**
     * Convert model name to permission key
     */
    private function getModelKey(string $model): string
    {
        // Handle special cases
        $specialCases = [
            'blog_category' => 'category',
            'event_registration' => 'event_registration',
            'f_a_q' => 'faq', // Fix FAQ model key
        ];

        return $specialCases[$model] ?? $model;
    }

    private function createSuperAdminRole(): void
    {
        $models = $this->getAvailableModels();

        $accessLevels = [
            'system' => true,
            'user' => true,
            'role' => true,
            'media' => true,
            'default' => true, // Full access to all models
        ];

        HexaRole::updateOrCreate(
            ['name' => 'Super Admin'],
            [
                'guard' => 'web',
                'access' => $this->generatePermissions($models, $accessLevels),
            ]
        );
    }

    private function createAdminRole(): void
    {
        $models = $this->getAvailableModels();

        $accessLevels = [
            'system' => true,
            'user' => [
                'index' => true,
                'create' => true,
                'update' => true,
                'delete' => false,
                'restore' => false,
                'replicate' => false,
                'reorder' => false,
                'force_delete' => false,
            ],
            'role' => false, // No role management
            'media' => [
                'index' => true,
                'create' => true,
                'update' => true,
                'delete' => true,
                'restore' => true,
                'replicate' => true,
                'reorder' => true,
                'force_delete' => false,
            ],
            'models' => [
                'settings' => ['index' => true, 'update' => false],
            ],
            'default' => [
                'index' => true,
                'create' => true,
                'update' => true,
                'delete' => true,
                'restore' => true,
                'replicate' => true,
                'reorder' => true,
                'force_delete' => false,
            ],
        ];

        HexaRole::updateOrCreate(
            ['name' => 'Admin'],
            [
                'guard' => 'web',
                'access' => $this->generatePermissions($models, $accessLevels),
            ]
        );
    }

    private function createEditorRole(): void
    {
        $models = $this->getAvailableModels();

        $accessLevels = [
            'system' => ['dashboard.index' => true, 'settings.index' => false, 'settings.update' => false],
            'user' => false, // No user management
            'role' => false, // No role management
            'media' => [
                'index' => true,
                'create' => true,
                'update' => true,
                'delete' => false,
                'restore' => false,
                'replicate' => false,
                'reorder' => false,
                'force_delete' => false,
            ],
            'models' => [
                'category' => [
                    'index' => true,
                    'create' => true,
                    'update' => false,
                    'delete' => false,
                    'restore' => false,
                    'replicate' => false,
                    'reorder' => false,
                    'force_delete' => false,
                ],
            ],
            'default' => [
                'index' => true,
                'create' => true,
                'update' => true,
                'delete' => false,
                'restore' => false,
                'replicate' => true,
                'reorder' => false,
                'force_delete' => false,
            ],
        ];

        HexaRole::updateOrCreate(
            ['name' => 'Editor'],
            [
                'guard' => 'web',
                'access' => $this->generatePermissions($models, $accessLevels),
            ]
        );
    }

    private function createUserRole(): void
    {
        $models = $this->getAvailableModels();

        $accessLevels = [
            'system' => ['dashboard.index' => true, 'settings.index' => false, 'settings.update' => false],
            'user' => false, // No user management
            'role' => false, // No role management
            'media' => false, // No media access
            'models' => [
                'event' => ['index' => true],
                'faq' => ['index' => true],
                'blog' => ['index' => true],
            ],
            'default' => false, // No access to other models by default
        ];

        HexaRole::updateOrCreate(
            ['name' => 'User'],
            [
                'guard' => 'web',
                'access' => $this->generatePermissions($models, $accessLevels),
            ]
        );
    }
}
