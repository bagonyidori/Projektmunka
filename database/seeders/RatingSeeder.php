<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Rating::factory(1500)->create();

        Movie::all()->each(function ($movie) {
            Rating::factory(fake()->numberBetween(1, 10))->create([
                'movie_id' => $movie->id,
            ]);
        });
    }


}
