<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function getMovies()
    {
        $pages = 25;
        for ($page = 1; $page <= $pages; $page++) {
            $resp = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => '69347c0868fbf37f48034f15e356362b', 'page' => $page]);
        }

        $genres = ['Comedy', 'Action', 'Horror', 'Rom-Com', 'Thriller', 'Sci-Fi', 'Drama', 'Romance', 'Fantasy'];
        $data = $resp->json();
        foreach ($data['results'] as $movieData) {
            Movie::updateOrCreate(
                [
                    'tmdb_id' => $movieData['id']
                ],
                [
                    'title' => $movieData['original_title'],
                    'plot' => $movieData['overview'],
                    'genre' => fake()->randomElement($genres),
                    'poster' => $movieData['poster_path'],
                    'releaseDate' => $movieData['release_date']
                ]
            );
        }
    }


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
    public function show(Movie $movie)
    {
        $movie = Movie::findOrFail($id);
        $related = Movie::where('id', '!=', $id)->latest()->take(8)->get();

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
