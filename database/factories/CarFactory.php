<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make' => fake()->word(),
            'model' => fake()->word(),
            'year' => fake()->year(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(1000, 10000),
            'user_id' => User::factory(),
        ];
    }
}
