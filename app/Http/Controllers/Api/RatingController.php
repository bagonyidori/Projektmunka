<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function index()
    {
        return Rating::all();
    }

    public function update(Request $request, Rating $rating)
    {
        $rating->update($request->all());

        return response()->json($rating);
    }
}
