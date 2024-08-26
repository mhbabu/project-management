<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        $adminOrLeader = User::whereIn('type', ['admin', 'team-leader'])->inRandomOrder()->first();
        $developer = User::where('type', 'developer')->inRandomOrder()->first();

        return [
            'project_id'    => Project::inRandomOrder()->first()->id,
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->paragraph,
            'status'        => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'assigned_to'   => $developer->id,
            'assigned_by'   => $adminOrLeader->id,
            'due_date'      => $this->faker->dateTimeBetween('now', '+1 year'),
            'completed_at'  => null,
        ];
    }
}
