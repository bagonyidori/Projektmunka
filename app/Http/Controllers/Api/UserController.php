<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //return User::all();
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Hibás email vagy jelszó'
            ], 401);
        }

        if (!$user->is_admin) {
            return response()->json([
                'message' => 'Nem admin felhasználó'
            ], 403);
        }

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'is_admin' => true
        ]);
    }
}
