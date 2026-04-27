<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
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

    public function test_movies_page_loads()
    {
        $response = $this->get('/movies');

        $response->assertStatus(200);
    }

    public function test_movie_search_returns_results()
    {
        Movie::factory()->create([
            'tmdb_id' => 222,
            'title' => 'Batman',
            'genre' => 'action',
            'plot' => 'dkjdkkkkcd',
            'releaseDate' => 2001 - 12 - 21
        ]);

        $response = $this->get('/movies?search=Batman');
        $response->assertSee('Batman');
    }

    public function test_movies_can_be_filtered()
    {
        Movie::factory()->create([
            'tmdb_id' => 351,
            'title' => 'Mario',
            'genre' => 'Drama',
            'plot' => 'kkkkkkkkkkpppppp',
            'releaseDate' => 2002 - 12 - 21
        ]);

        $response = $this->get('/movies?genre=Drama');

        $response->assertSee('Drama');
    }
}
