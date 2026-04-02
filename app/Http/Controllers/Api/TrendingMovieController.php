<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrendingMovie;
use App\Models\Movie;

class TrendingMovieController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->movies);
        TrendingMovie::truncate();

        try {
            $date = now()->toDateString();

            $movies = Movie::whereIn('id', $request->movies)->get();

            foreach ($movies as $movie) {
                TrendingMovie::create([
                    'movie_id' => $movie->id,
                    'date' => $date
                ]);
            }

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
