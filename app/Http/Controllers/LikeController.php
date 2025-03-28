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
        $userId = Auth::id();
        $likes = Like::where('user_id', $userId)->get();

        return response()->json([
            'likes' => $likes,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'liked_user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Verificar si ya existe un "Like" entre estos usuarios
        $existingLike = Like::where('user_id', Auth::id())
            ->where('liked_user_id', $request->liked_user_id)
            ->first();

        if ($existingLike) {
            return response()->json([
                'message' => 'Ya has dado Like a este usuario',
                'status' => 409
            ], 409);
        }

        $like = Like::create([
            'user_id' => Auth::id(),
            'liked_user_id' => $request->liked_user_id,
        ]);

        return response()->json([
            'message' => 'Like agregado',
            'data' => $like,
            'status' => 201
        ], 201);
    }

    public function destroy($id)
    {
        $like = Like::where('user_id', Auth::id())->where('liked_user_id', $id)->first();

        if (!$like) {
            return response()->json([
                'message' => 'No existe este Like',
                'status' => 404
            ], 404);
        }

        $like->delete();

        return response()->json([
            'message' => 'Like eliminado',
            'status' => 200
        ], 200);
    }
}
