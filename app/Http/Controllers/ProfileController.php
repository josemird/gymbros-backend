<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo,
            'gym' => $user->gym,
            'age' => $user->age,
            'favorite_exercises' => $user->favorite_exercises,
            'goals' => $user->goals,
            'hobbies' => $user->hobbies,
        ]);
    }
}
