<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $like = Like::where('user_id', $userId)->get();

        return response()->json($like);
    }

    public function store(Request $request)
    {
        $request->validate([
            'liked_user_id' => 'required|exists:users,id',
        ]);

        $like = Like::create([
            'user_id' => Auth::id(),
            'liked_user_id' => $request->liked_user_id,
        ]);

        return response()->json($like, 201);
    }

    public function destroy($id)
    {
        $like = Like::where('user_id', Auth::id())->where('liked_user_id', $id)->firstOrFail();
        $like->delete();

        return response()->json(['message' => 'Like removed']);
    }
}
