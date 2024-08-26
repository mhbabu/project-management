<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $types = ['developer', 'team-leader'];

        return [
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => bcrypt('password'), // Default password for testing
            'remember_token'    => Str::random(10),
            'type'              => $this->faker->randomElement($types),
        ];
    }

    public function teamLeader()
    {
        return $this->state([
            'type' => 'team-leader',
        ]);
    }

    public function developer()
    {
        return $this->state([
            'type' => 'developer',
        ]);
    }
}
