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
            foreach ($request->movies as $movieId) {
                TrendingMovie::create([
                    'movie_id' => $movieId
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
