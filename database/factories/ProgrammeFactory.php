<?php

namespace Database\Factories;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Programme>
 */
class ProgrammeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 20),
            'title' => fake()->sentence(4),
            'pillar' => fake()->randomElement(['Careers', 'Skills', 'Enterprise', 'Teachers']),
        ];
    }
}
