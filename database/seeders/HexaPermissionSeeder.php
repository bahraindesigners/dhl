<?php

namespace Database\Seeders;

use Hexters\HexaLite\Models\HexaRole;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles with Hexa Lite permissions
        $this->createSuperAdminRole();
        $this->createAdminRole();
        $this->createEditorRole();
        $this->createUserRole();
    }

    private function createSuperAdminRole(): void
    {
        HexaRole::updateOrCreate(
            ['name' => 'Super Admin'],
            [
                'guard' => 'web',
                'access' => [
                    // User Management
                    'user.index' => true,
                    'user.create' => true,
                    'user.update' => true,
                    'user.delete' => true,
                    'user.restore' => true,
                    'user.replicate' => true,
                    'user.reorder' => true,
                    'user.force_delete' => true,

                    // Role Management
                    'role.index' => true,
                    'role.create' => true,
                    'role.update' => true,
                    'role.delete' => true,
                    'role.restore' => true,
                    'role.replicate' => true,
                    'role.reorder' => true,
                    'role.force_delete' => true,

                    // Event Management
                    'event.index' => true,
                    'event.create' => true,
                    'event.update' => true,
                    'event.delete' => true,
                    'event.restore' => true,
                    'event.replicate' => true,
                    'event.reorder' => true,
                    'event.force_delete' => true,

                    // FAQ Management
                    'faq.index' => true,
                    'faq.create' => true,
                    'faq.update' => true,
                    'faq.delete' => true,
                    'faq.restore' => true,
                    'faq.replicate' => true,
                    'faq.reorder' => true,
                    'faq.force_delete' => true,

                    // Blog Management
                    'blog.index' => true,
                    'blog.create' => true,
                    'blog.update' => true,
                    'blog.delete' => true,
                    'blog.restore' => true,
                    'blog.replicate' => true,
                    'blog.reorder' => true,
                    'blog.force_delete' => true,

                    // Category Management
                    'category.index' => true,
                    'category.create' => true,
                    'category.update' => true,
                    'category.delete' => true,
                    'category.restore' => true,
                    'category.replicate' => true,
                    'category.reorder' => true,
                    'category.force_delete' => true,

                    // Media Management
                    'media.index' => true,
                    'media.create' => true,
                    'media.update' => true,
                    'media.delete' => true,
                    'media.restore' => true,
                    'media.replicate' => true,
                    'media.reorder' => true,
                    'media.force_delete' => true,

                    // Dashboard
                    'dashboard.index' => true,

                    // Settings
                    'settings.index' => true,
                    'settings.update' => true,
                ],
            ]
        );
    }

    private function createAdminRole(): void
    {
        HexaRole::updateOrCreate(
            ['name' => 'Admin'],
            [
                'guard' => 'web',
                'access' => [
                    // User Management (limited)
                    'user.index' => true,
                    'user.create' => true,
                    'user.update' => true,
                    'user.delete' => false,
                    'user.restore' => false,
                    'user.replicate' => false,
                    'user.reorder' => false,
                    'user.force_delete' => false,

                    // Event Management
                    'event.index' => true,
                    'event.create' => true,
                    'event.update' => true,
                    'event.delete' => true,
                    'event.restore' => true,
                    'event.replicate' => true,
                    'event.reorder' => true,
                    'event.force_delete' => false,

                    // FAQ Management
                    'faq.index' => true,
                    'faq.create' => true,
                    'faq.update' => true,
                    'faq.delete' => true,
                    'faq.restore' => true,
                    'faq.replicate' => true,
                    'faq.reorder' => true,
                    'faq.force_delete' => false,

                    // Blog Management
                    'blog.index' => true,
                    'blog.create' => true,
                    'blog.update' => true,
                    'blog.delete' => true,
                    'blog.restore' => true,
                    'blog.replicate' => true,
                    'blog.reorder' => true,
                    'blog.force_delete' => false,

                    // Category Management
                    'category.index' => true,
                    'category.create' => true,
                    'category.update' => true,
                    'category.delete' => true,
                    'category.restore' => true,
                    'category.replicate' => true,
                    'category.reorder' => true,
                    'category.force_delete' => false,

                    // Media Management
                    'media.index' => true,
                    'media.create' => true,
                    'media.update' => true,
                    'media.delete' => true,
                    'media.restore' => true,
                    'media.replicate' => true,
                    'media.reorder' => true,
                    'media.force_delete' => false,

                    // Dashboard
                    'dashboard.index' => true,

                    // Settings (limited)
                    'settings.index' => true,
                    'settings.update' => false,
                ],
            ]
        );
    }

    private function createEditorRole(): void
    {
        HexaRole::updateOrCreate(
            ['name' => 'Editor'],
            [
                'guard' => 'web',
                'access' => [
                    // Event Management (limited)
                    'event.index' => true,
                    'event.create' => true,
                    'event.update' => true,
                    'event.delete' => false,
                    'event.restore' => false,
                    'event.replicate' => true,
                    'event.reorder' => false,
                    'event.force_delete' => false,

                    // FAQ Management
                    'faq.index' => true,
                    'faq.create' => true,
                    'faq.update' => true,
                    'faq.delete' => false,
                    'faq.restore' => false,
                    'faq.replicate' => true,
                    'faq.reorder' => false,
                    'faq.force_delete' => false,

                    // Blog Management
                    'blog.index' => true,
                    'blog.create' => true,
                    'blog.update' => true,
                    'blog.delete' => false,
                    'blog.restore' => false,
                    'blog.replicate' => true,
                    'blog.reorder' => false,
                    'blog.force_delete' => false,

                    // Category Management (view and create only)
                    'category.index' => true,
                    'category.create' => true,
                    'category.update' => false,
                    'category.delete' => false,
                    'category.restore' => false,
                    'category.replicate' => false,
                    'category.reorder' => false,
                    'category.force_delete' => false,

                    // Media Management
                    'media.index' => true,
                    'media.create' => true,
                    'media.update' => true,
                    'media.delete' => false,
                    'media.restore' => false,
                    'media.replicate' => false,
                    'media.reorder' => false,
                    'media.force_delete' => false,

                    // Dashboard
                    'dashboard.index' => true,
                ],
            ]
        );
    }

    private function createUserRole(): void
    {
        HexaRole::updateOrCreate(
            ['name' => 'User'],
            [
                'guard' => 'web',
                'access' => [
                    // Dashboard only
                    'dashboard.index' => true,

                    // View only access to some content
                    'event.index' => true,
                    'faq.index' => true,
                    'blog.index' => true,
                ],
            ]
        );
    }
}
