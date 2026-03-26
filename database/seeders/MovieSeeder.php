<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Http;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = 25;
        for ($page = 1; $page <= $pages; $page++) {
            $resp = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => env('TMBD_API_KEY'), 'page' => $page]);

            $genres = ['Comedy', 'Action', 'Horror', 'Rom-Com', 'Thriller', 'Sci-Fi', 'Drama', 'Romance', 'Fantasy'];
            $data = $resp->json();
            foreach ($data['results'] as $movieData) {

                if (!isset($movieData['id']) || empty($movieData['release_date'])) {
                    continue;
                }

                Movie::updateOrCreate(
                    [
                        'tmdb_id' => $movieData['id']
                    ],
                    [
                        'title' => $movieData['title'],
                        'plot' => $movieData['overview'],
                        'genre' => fake()->randomElement($genres),
                        'poster' => $movieData['poster_path'],
                        'releaseDate' => $movieData['release_date']
                    ]
                );
            }
        }
    }
}
