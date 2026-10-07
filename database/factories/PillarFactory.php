<?php

namespace Database\Factories;

use App\Models\Pillar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pillar>
 */
class PillarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 10),
            'step' => fake()->randomElement(['First', 'Second', 'Third', 'Last']),
            'verb' => fake()->unique()->word(),
            'figure' => fake()->randomElement(['signpost', 'gears', 'stall', 'chalkboard']),
            'title' => fake()->sentence(3),
            'body' => fake()->sentence(),
        ];
    }
}
