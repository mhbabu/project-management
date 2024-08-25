<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'Projects', 
            'Tasks', 
            'Subtasks'
        ];

        foreach ($resources as $resource) {
            Resource::firstOrCreate(['name' => $resource]);
        }
    }
}
