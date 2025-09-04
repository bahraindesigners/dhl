<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions for each entity
        $permissions = [
            // Events
            'view events',
            'create events',
            'edit events',
            'delete events',
            'restore events',
            'force delete events',
            'replicate events',
            'reorder events',

            // Blogs
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
            'restore blogs',
            'force delete blogs',
            'replicate blogs',
            'reorder blogs',

            // Blog Categories
            'view blog categories',
            'create blog categories',
            'edit blog categories',
            'delete blog categories',
            'restore blog categories',
            'force delete blog categories',
            'replicate blog categories',
            'reorder blog categories',

            // FAQs
            'view faqs',
            'create faqs',
            'edit faqs',
            'delete faqs',
            'restore faqs',
            'force delete faqs',
            'replicate faqs',
            'reorder faqs',

            // Event Registrations
            'view event registrations',
            'create event registrations',
            'edit event registrations',
            'delete event registrations',
            'restore event registrations',
            'force delete event registrations',
            'replicate event registrations',
            'reorder event registrations',

            // Home Sliders
            'view home sliders',
            'create home sliders',
            'edit home sliders',
            'delete home sliders',
            'restore home sliders',
            'force delete home sliders',
            'replicate home sliders',
            'reorder home sliders',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
            'restore users',
            'force delete users',
            'replicate users',
            'reorder users',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $user = Role::firstOrCreate(['name' => 'User']); // Regular user role for new registrations

        // Assign all permissions to Super Admin (handled by Gate::before)
        // Give selective permissions to other roles
        $admin->givePermissionTo([
            'view events', 'create events', 'edit events', 'delete events',
            'view blogs', 'create blogs', 'edit blogs', 'delete blogs',
            'view blog categories', 'create blog categories', 'edit blog categories', 'delete blog categories',
            'view faqs', 'create faqs', 'edit faqs', 'delete faqs',
            'view event registrations', 'edit event registrations', 'delete event registrations',
            'view home sliders', 'create home sliders', 'edit home sliders', 'delete home sliders',
            'view users',
        ]);

        $editor->givePermissionTo([
            'view events', 'create events', 'edit events',
            'view blogs', 'create blogs', 'edit blogs',
            'view blog categories', 'create blog categories', 'edit blog categories',
            'view faqs', 'create faqs', 'edit faqs',
            'view event registrations',
            'view home sliders', 'create home sliders', 'edit home sliders',
        ]);

        // Regular users get minimal permissions (can view public content)
        $user->givePermissionTo([
            'view events',
            'view blogs',
            'view blog categories',
            'view faqs',
        ]);
    }
}
