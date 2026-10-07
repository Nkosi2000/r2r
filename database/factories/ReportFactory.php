<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['Annual Report', 'Impact Report']),
            'year' => fake()->numberBetween(2015, 2026),
            'file' => 'reports/'.fake()->slug(2).'.pdf',
        ];
    }
}
