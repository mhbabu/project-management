<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Resource;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $resources = [
            'Projects' => ['create', 'edit', 'update', 'delete'],
            'Tasks' => ['create', 'edit', 'update', 'delete'],
            'Subtasks' => ['create', 'edit', 'update', 'delete'],
        ];

        foreach ($resources as $resourceName => $actions) {
            $resource = Resource::where('name', $resourceName)->first();

            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'resource_id' => $resource->id,
                    'action' => $action,
                ]);
            }
        }
    }
}
