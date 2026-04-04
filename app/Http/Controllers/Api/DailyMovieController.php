<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyMovie;
use App\Models\Movie;
use Carbon\Carbon;

class DailyMovieController extends Controller
{
    public function index()
    {
        return DailyMovie::all();
    }

    public function store(Request $request)
    {
        DailyMovie::truncate();
        //dd($request->movies);
        try {
            $movies = Movie::whereIn('id', $request->movies)->get();
            $date = $request->date;
            $nowTime = now();

            foreach ($movies as $movie) {
                DailyMovie::create([
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
