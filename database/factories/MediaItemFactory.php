<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Models\MediaItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaItem>
 */
class MediaItemFactory extends Factory
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
            'type' => MediaType::Photo,
            'title' => fake()->sentence(3),
            'subtitle' => null,
            'path' => 'images/gallery/'.fake()->slug(2).'.jpg',
        ];
    }
}
