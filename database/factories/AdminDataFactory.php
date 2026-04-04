<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Rating>
 */
class AdminDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nowTime = now();
        return [
            "daily_last_update" => $nowTime->toDateTimeString(),
            "trending_last_update" => $nowTime->toDateTimeString()
        ];
    }
}
