<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StreamingVote;

class VoteController extends Controller
{
    public function index()
    {
        return StreamingVote::all();
    }

    public function update(Request $request, $movieId)
    {
        $vote = StreamingVote::where('movie_id', $movieId)->first();
    
        if (!$vote) {
            return response()->json(['message' => 'Not found'], 404);
        }
    
        $vote->update($request->all());
    
        return response()->json($vote);
    }
}
