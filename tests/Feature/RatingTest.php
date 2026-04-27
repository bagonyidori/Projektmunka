<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    /*public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/

    public function test_user_can_rate_a_movie()
    {

        $user = User::factory()->create();
        $movie = Movie::factory()->create([
            'tmdb_id' => 221,
            'title' => 'Superman',
            'genre' => 'Action',
            'plot' => 'pppppppppp',
            'releaseDate' => '2021-12-12'
        ]);

        $response = $this->actingAs($user)->post(route('rating.create', ['id' => $movie->id]), [
            //'movie_id' => $movie->id,
            'rating' => 4,
            'content' => 'yey!'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('ratings', [
            'movie_id' => $movie->id,
            'user_id' => $user->id,
            'stars' => 4,
            'comment' => 'yey!'
        ]);
    }
}
