<?php

namespace Database\Factories;

use App\Models\Well;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Well>
 */
class WellFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Скважина №' . $this->faker->unique()->numberBetween(100, 999),
        ];
    }
}
