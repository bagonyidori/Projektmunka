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
}
