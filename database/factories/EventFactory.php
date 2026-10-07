<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state: an event that has already happened.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['Careers & Skills Expo', 'Entrepreneurship Roadshow', 'Rural Teachers Summit']),
            'place' => fake()->randomElement(['Limpopo', 'Mpumalanga', 'Eastern Cape', 'North West']),
            'held_on' => fake()->dateTimeBetween('-5 years', '-1 day'),
            'latitude' => fake()->latitude(-34, -22),
            'longitude' => fake()->longitude(17, 32),
        ];
    }

    /**
     * An event still to come.
     */
    public function upcoming(): static
    {
        return $this->state(fn (): array => [
            'held_on' => fake()->dateTimeBetween('+1 week', '+6 months'),
        ]);
    }
}
