<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::latest()->paginate(24);
        return view('movies.index', compact('movies'));
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
    $movie = \App\Models\Movie::where('id', $id)->first();

    if (!$movie) {
        return abort(404);
    }

    $related = \App\Models\Movie::where('genre', $movie->genre)
                ->where('id', '!=', $id)
                ->take(4)
                ->get();

    return view('movies.show', compact('movie', 'related'));
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
        $featured = Movie::latest()->take(6)->get();
        $trending = Movie::latest()->take(12)->get();

        return view('home', compact('featured', 'trending'));
    }

}
