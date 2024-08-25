<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $teamLeader = User::inRandomOrder()->first();

        return [
            'name'           => $this->faker->sentence(3),
            'description'    => $this->faker->paragraph,
            'team_leader_id' => $teamLeader ? $teamLeader->id : null, // Default to null if no user found
        ];
    }
}
