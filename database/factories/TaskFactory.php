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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;

    public function definition()
    {
        return [
            'project_id'    => Project::inRandomOrder()->first()->id,
            'title'         => $this->faker->sentence(4),
            'description'   => $this->faker->paragraph,
            'status'        => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'assigned_to'   => User::inRandomOrder()->first()->id,
            'assigned_by'   => User::inRandomOrder()->first()->id,
            'due_date'      => $this->faker->dateTimeBetween('now', '+1 year'),
            'completed_at'  => null,
        ];
    }
}
