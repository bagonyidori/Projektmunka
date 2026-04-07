<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "movie_id" => fake()->numberBetween(1, 420),
            "user_id" => fake()->numberBetween(1, 10),
            "stars" => fake()->numberBetween(1, 10)
        ];
    }
}
