<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminData;

class AdminDataController extends Controller
{
    public function index()
    {
        return response()->json(
            AdminData::all()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'daily_last_update' => $item->daily_last_update->toISOString(),
                    'trending_last_update' => $item->trending_last_update->toISOString(),
                ];
            })
        );
    }

    public function update(Request $request)
    {
        //dd('bejött');
        $request->validate([
            'daily' => 'required|date_format:Y-m-d\TH:i:sP',
            'trending' => 'required|date_format:Y-m-d\TH:i:sP'
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
