<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminData;

class AdminDataController extends Controller
{
    public function index()
    {
        return AdminData::all();
    }

    public function update(Request $request)
    {
        //dd('bejött');
        $request->validate([
            'daily' => 'required|date',
            'trending' => 'required|date'
        ]);

        $data = AdminData::first();

        if ($data) {
            $data->update([
                'daily_last_update' => $request->daily,
                'trending_last_update' => $request->trending
            ]);
        } else {
            $data = AdminData::create([
                'daily_last_update' => $request->daily,
                'trending_last_update' => $request->trending
            ]);
        }

        return response()->json($data);
    }
}
