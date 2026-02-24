<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
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
            // CMS
            'manage cms',
            'manage pages',
            'manage services',
            'manage products',
            'manage bundles',
            'manage faqs',
            'manage sliders',
            'manage clients',
            'manage team',
            'manage map-data',
            
            // Content moderation
            'manage reviews',
            'approve reviews',
            'escalate reviews',
            
            // Enquiries & Chat
            'manage enquiries',
            'manage chat',
            
            // Users
            'manage users',
            'assign roles',
            
            // Settings
            'manage settings',
            'view audit-logs',
            'manage newsletter',
            
            // Blogs
            'manage blogs',

            // AI Features
            'use ai-assistant',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $userRole = Role::create(['name' => 'user']);

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'manage cms',
            'manage pages',
            'manage blogs',
            'manage services',
            'manage products',
            'manage bundles',
            'manage faqs',
            'manage sliders',
            'manage clients',
            'manage team',
            'manage map-data',
            'use ai-assistant',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage cms',
            'manage pages',
            'manage services',
            'manage products',
            'manage bundles',
            'manage faqs',
            'manage sliders',
            'manage clients',
            'manage team',
            'manage map-data',
            'manage reviews',
            'approve reviews',
            'manage enquiries',
            'manage chat',
            'manage blogs',
            'manage newsletter',
            'use ai-assistant',
        ]);

        $superadminRole = Role::create(['name' => 'superadmin']);
        $superadminRole->givePermissionTo(Permission::all());

        $this->command->info('Roles and permissions created successfully!');
    }
}
