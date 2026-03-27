<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return Movie::all();
    }
}
