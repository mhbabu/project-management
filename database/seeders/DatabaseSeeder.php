<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ResourceTableSeeder::class,
            // PermissionTableSeeder::class,
            // RoleTableSeeder::class,
            UserTableSeeder::class,
        ]);

        User::factory(20)->create();
        Project::factory(10)->create()->each(function ($project) {
            Task::factory(5)->create(['project_id' => $project->id])->each(function ($task) {
                Subtask::factory(3)->create(['task_id' => $task->id]);
            });
        });
    }
}
