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
        $genreResp = Http::get('https://api.themoviedb.org/3/genre/movie/list', ['api_key' => env('TMBD_API_KEY'), 'language' => 'hu-HU']);
        $genreData = $genreResp->json();

        $pages = 25;
        for ($page = 1; $page <= $pages; $page++) {
            $resp = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => env('TMBD_API_KEY'), 'page' => $page, 'language' => 'hu-HU']);
            

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

                /*$plot = $movieData['overview'];
                $plotRes = Http::withHeaders(['Authorization' => 'DeepL-Auth-Key ' . env('DEEPL_API_KEY'),
                ])->post('https://api-free.deepl.com/v2/translate', ['text' => [$plot],'target_lang' => 'HU']);
                //dd($plotRes->json());
                $response = $plotRes->json();

                if (!$plotRes->successful() || !isset($response['translations'][0]['text'])) {
                    $translatedPlot = $plot;
                } else {
                    $translatedPlot = $response['translations'][0]['text'] ?? $plot;
                }*/

                $trailerResp = Http::get("https://api.themoviedb.org/3/movie/{$movieData['id']}/videos", ['api_key' => env('TMBD_API_KEY'), 'language' => 'hu-HU']);
                $trailerData = $trailerResp->json();

                $key = collect($trailerData['results'])->first(function ($video)
                {
                    return $video['type'] === 'Trailer'
                    && $video['site'] === 'YouTube'
                    && $video['official'];
                })['key'] ?? null;

                Movie::updateOrCreate(
                    [
                        'tmdb_id' => $movieData['id']
                    ],
                    [
                        'title' => $movieData['title'],
                        'genre' => $genreStr,
                        //'plot' => $translatedPlot,
                        'plot' => $movieData['overview'],
                        'poster' => $movieData['poster_path'],
                        'releaseDate' => $movieData['release_date'],
                        'trailerUrl' => $key ? "https://www.youtube.com/watch?v=" . $key : null 
                    ]
                );
            }
        }
    }
}
