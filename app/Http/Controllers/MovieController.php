<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\DailyMovie;
use App\Models\TrendingMovie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Movie::query();
        if ($request->has('genre') && $request->genre != '') {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $movies = $query->latest()->withAvg('ratings', 'stars')->paginate(24)->withQueryString();
        $dailyMovies = DailyMovie::with('movie')->get();
        $trendingMovies = TrendingMovie::with('movie')->get();

        return view('movies.index', compact('movies', 'dailyMovies', 'trendingMovies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //dd($id);
        $movie = \App\Models\Movie::where('id', $id)->first();

        if (!$movie) {
            return abort(404);
        }

        $related = Movie::where('genre', $movie->genre)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        $ratings = $movie->ratings()->get();

        $sum_rating = 0;
        foreach ($ratings as $rating) {
            $sum_rating += $rating->stars;
        }
        $average_rating = 0;
        if (count($ratings)) {
            $average_rating = $sum_rating / count($ratings);
        }

        return view('movies.show', compact('movie', 'related', 'ratings', 'average_rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }


    public function home()
    {
        $featured = Movie::latest()->withAvg('ratings', 'stars')->take(8)->get();
        $trendingMovies = TrendingMovie::with(['movie.ratings'])->get();
        $dailyMovies = DailyMovie::with(['movie.ratings'])->whereDate('date', today())->get();
        $upcomingMovies = Movie::where('releaseDate', '>', now())->withAvg('ratings', 'stars')->orderBy('releaseDate', 'asc')->take(8)->get();

        return view('home', compact('featured', 'trendingMovies', 'dailyMovies', 'upcomingMovies'));
    }

    public function profile()
    {
        $user = auth()->user();

        $favorites = $user->favoriteMovies()->get();

        return view('profile.profile', [
            'user' => $user,
            'favorites' => $favorites
        ]);
    }

    public function favouriteMovie(Movie $id)
    {
        $userId = auth()->id();
        $favourited = $id->favoritedBy()->where('user_id', $userId)->exists();
        if ($favourited) {
            $id->favoritedBy()->detach($userId);
        } else {
            $id->favoritedBy()->attach($userId);
        }

        return redirect()->back();
    }

    public function votePlatform(Request $request, Movie $movie, $platform)
    {
        $allowedPlatforms = ['netflix', 'disney', 'hbo', 'apple', 'amazon'];
        $action = $request->input('action');

        if (!in_array($platform, $allowedPlatforms)) {
            return response()->json(['error' => 'Érvénytelen platform'], 400);
        }

        $votes = $movie->streamingVotes()->firstOrCreate(
            ['movie_id' => $movie->id],
            ['netflix' => 0, 'disney' => 0, 'hbo' => 0, 'apple' => 0, 'amazon' => 0]
        );

        if ($action === 'up') {
            $votes->increment($platform);
        } else {
            if ($votes->$platform > 0) {
                $votes->decrement($platform);
            }
        }

        return response()->json([
            'success' => true,
            'new_count' => $votes->refresh()->$platform
        ]);
    }

}
