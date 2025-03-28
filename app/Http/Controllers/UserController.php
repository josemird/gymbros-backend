<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'username' => 'required',
            'photo' => 'required',
            'gym' => 'required',
            'age' => 'required|digits_between:1,3|numeric',
            'favorite_exercises' => 'required',
            'goals' => 'required',
            'hobbies' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'photo' => $request->photo,
            'gym' => $request->gym,
            'age' => $request->age,
            'favorite_exercises' => $request->favorite_exercises,
            'goals' => $request->goals,
            'hobbies' => $request->hobbies
        ]);

        return response()->json([
            'user' => $user,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no existe',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'user' => $user,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no existe',
                'status' => 404
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no existe',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'username' => 'required',
            'photo' => 'required',
            'gym' => 'required',
            'age' => 'required|digits_between:1,3|numeric',
            'favorite_exercises' => 'required',
            'goals' => 'required',
            'hobbies' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'username' => $request->username,
            'photo' => $request->photo,
            'gym' => $request->gym,
            'age' => $request->age,
            'favorite_exercises' => $request->favorite_exercises,
            'goals' => $request->goals,
            'hobbies' => $request->hobbies
        ]);

        return response()->json([
            'message' => 'Usuario actualizado',
            'user' => $user,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no existe',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'age' => 'digits_between:1,3|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $user->fill($request->only([
            'name', 'email', 'username', 'photo', 'gym', 'age', 'favorite_exercises', 'goals', 'hobbies'
        ]));

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado',
            'user' => $user,
            'status' => 200
        ], 200);
    }
}
