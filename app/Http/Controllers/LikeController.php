<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function index()
    {
        $likes = Like::where('user_id', Auth::id())
            ->with('likedUser.gym')
            ->get();

        return response()->json(['likes' => $likes], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'liked_user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $exists = Like::where('user_id', Auth::id())
            ->where('liked_user_id', $request->liked_user_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Ya has dado like a este usuario'], 409);
        }

        $like = Like::create([
            'user_id' => Auth::id(),
            'liked_user_id' => $request->liked_user_id,
        ]);

        return response()->json(['like' => $like], 201);
    }

    public function destroy($id)
    {
        $like = Like::where('user_id', Auth::id())
            ->where('liked_user_id', $id)
            ->first();

        if (!$like) {
            return response()->json(['message' => 'No se encontró el like'], 404);
        }

        $like->delete();

        return response()->json(['message' => 'Like eliminado'], 200);
    }
}
