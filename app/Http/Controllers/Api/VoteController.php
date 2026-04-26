<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\StreamingVote;

class VoteController extends Controller
{
    public function index()
    {
        return StreamingVote::all();
    }

    public function update(Request $request, StreamingVote $streamingVote)
    {
        //
    }
}
