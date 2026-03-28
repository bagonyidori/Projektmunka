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
        $genreResp = Http::get('https://api.themoviedb.org/3/genre/movie/list', ['api_key' => env('TMBD_API_KEY')]);
        $genreData = $genreResp->json();

        $pages = 25;
        for ($page = 1; $page <= $pages; $page++) {
            $resp = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => env('TMBD_API_KEY'), 'page' => $page]);
            

            //$genres = ['Comedy', 'Action', 'Horror', 'Rom-Com', 'Thriller', 'Sci-Fi', 'Drama', 'Romance', 'Fantasy'];
            $data = $resp->json();

            foreach ($data['results'] as $movieData) {

                if (!isset($movieData['id']) || empty($movieData['release_date'])) {
                    continue;
                }

                $genreIds = $movieData['genre_ids'];
                $names = [];
                foreach ($genreData['genres'] as $genre)
                {
                    if(in_array($genre['id'], $genreIds))
                    {
                        $names[] = $genre['name'];
                    }
                }
                $genreStr = implode(", ", $names);

                Movie::updateOrCreate(
                    [
                        'tmdb_id' => $movieData['id']
                    ],
                    [
                        'title' => $movieData['title'],
                        'genre' => $genreStr,
                        'plot' => $movieData['overview'],
                        'poster' => $movieData['poster_path'],
                        'releaseDate' => $movieData['release_date']
                    ]
                );
            }
        }
    }
}
