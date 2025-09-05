<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Blog management
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',

            // Blog category management
            'view blog categories',
            'create blog categories',
            'edit blog categories',
            'delete blog categories',
            'restore blog categories',
            'force delete blog categories',
            'replicate blog categories',
            'reorder blog categories',

            // Event management
            'view events',
            'create events',
            'edit events',
            'delete events',

            // Event registration management
            'view event registrations',
            'create event registrations',
            'edit event registrations',
            'delete event registrations',
            'restore event registrations',
            'force delete event registrations',
            'replicate event registrations',
            'reorder event registrations',

            // Member profile management
            'view member-profiles',
            'create member-profiles',
            'edit member-profiles',
            'delete member-profiles',

            // FAQ management
            'view faqs',
            'create faqs',
            'edit faqs',
            'delete faqs',

            // Download management
            'view downloads',
            'create downloads',
            'edit downloads',
            'delete downloads',

            // Home slider management
            'view home-sliders',
            'create home-sliders',
            'edit home-sliders',
            'delete home-sliders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $this->createSuperAdminRole();
        $this->createAdminRole();
        $this->createEditorRole();
        $this->createUserRole();
    }

    private function createSuperAdminRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'super_admin']);
        $role->givePermissionTo(Permission::all());
    }

    private function createAdminRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);

        $permissions = [
            'view blogs', 'create blogs', 'edit blogs', 'delete blogs',
            'view blog categories', 'create blog categories', 'edit blog categories', 'delete blog categories',
            'view events', 'create events', 'edit events', 'delete events',
            'view event registrations', 'create event registrations', 'edit event registrations', 'delete event registrations',
            'view member-profiles', 'create member-profiles', 'edit member-profiles', 'delete member-profiles',
            'view faqs', 'create faqs', 'edit faqs', 'delete faqs',
            'view downloads', 'create downloads', 'edit downloads', 'delete downloads',
            'view home-sliders', 'create home-sliders', 'edit home-sliders', 'delete home-sliders',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createEditorRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor']);

        $permissions = [
            'view blogs', 'create blogs', 'edit blogs',
            'view blog categories', 'create blog categories', 'edit blog categories',
            'view events', 'create events', 'edit events',
            'view event registrations', 'create event registrations', 'edit event registrations',
            'view faqs', 'create faqs', 'edit faqs',
            'view downloads', 'create downloads', 'edit downloads',
            'view home-sliders', 'create home-sliders', 'edit home-sliders',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createUserRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'user']);

        $permissions = [
            'view blogs',
            'view blog categories',
            'view events',
            'view event registrations',
            'view faqs',
            'view downloads',
        ];

        $role->givePermissionTo($permissions);
    }
}
