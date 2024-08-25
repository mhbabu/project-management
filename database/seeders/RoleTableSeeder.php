<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define roles and permissions
        $roles = [
            'admin' => [
                'Projects' => ['create', 'edit', 'update', 'delete'],
                'Tasks'    => ['create', 'edit', 'update', 'delete'],
                'Subtasks' => ['create', 'edit', 'update', 'delete'],
            ],
            'project_manager' => [
                'Projects' => ['create', 'edit', 'update', 'delete'],
                'Tasks'    => ['create', 'edit', 'update', 'delete'],
            ],
            'team_leader' => [
                'Tasks'    => ['create', 'edit', 'update', 'delete'],
                'Subtasks' => ['create', 'edit', 'update', 'delete'],
            ],
            'developer' => [
                'Subtasks' => ['create', 'edit', 'update', 'delete'],
            ],
        ];

        foreach ($roles as $roleName => $resources) {
            // Create or get the role
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($resources as $resourceName => $actions) {
                foreach ($actions as $action) {
                    // Create permission
                    $permissionName = "{$resourceName} {$action}";
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);

                    // Assign permission to role
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
