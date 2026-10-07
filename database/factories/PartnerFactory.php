<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
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
            'name' => fake()->company(),
            'description' => fake()->catchPhrase(),
            'logo' => 'images/partners/'.fake()->slug(2).'.png',
            'website' => fake()->optional()->url(),
        ];
    }
}
