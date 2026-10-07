<?php

namespace Database\Factories;

use App\Models\ResourceLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResourceLink>
 */
class ResourceLinkFactory extends Factory
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
            'group' => fake()->randomElement(['Study & bursaries', 'Jobs & youth opportunities']),
            'title' => fake()->company(),
            'description' => fake()->sentence(),
            'url' => fake()->url(),
        ];
    }
}
