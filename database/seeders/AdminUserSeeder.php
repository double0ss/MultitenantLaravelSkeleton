<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or retrieve Platform Owner Role
        $ownerRole = Role::firstOrCreate(
            ['slug' => 'platform-owner'],
            [
                'name' => 'Platform Owner',
                'is_system_role' => true
            ]
        );

        // Create Basic Modules
        $modules = [
            'Companies' => 'Manage platform companies',
            'Users' => 'Manage platform users',
            'Roles' => 'Manage roles and permissions',
            'Modules' => 'Manage system modules'
        ];

        foreach ($modules as $name => $description) {
            $module = Module::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'active' => true
                ]
            );

            // Create CRUD permissions for each module
            $actions = ['view', 'create', 'update', 'delete'];
            foreach ($actions as $action) {
                $permissionSlug = $action . '-' . Str::slug($name);
                $permission = Permission::firstOrCreate(
                    ['slug' => $permissionSlug],
                    [
                        'name' => ucfirst($action) . ' ' . $name,
                        'module_id' => $module->id
                    ]
                );

                // Attach permission if not already attached
                if (!$ownerRole->permissions->contains($permission->id)) {
                    $ownerRole->permissions()->attach($permission->id);
                }
            }
        }

        // Create Platform Owner User if not exists
        User::firstOrCreate(
            ['email' => 'double0@nauta.cu'],
            [
                'name' => 'Platform Owner',
                'password' => Hash::make('123'),
                'is_admin' => true,
                'is_active' => true,
                'role_id' => $ownerRole->id
            ]
        );
    }
}