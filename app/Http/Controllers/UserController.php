<?php

// Descripción: Controlador para manejar las operaciones CRUD de usuarios en una API RESTful, José Miguel Ramírez Domínguez.

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('gym')->get();
        return response()->json(['users' => $users, 'status' => 200], 200);
    }

    public function show($id)
    {
        $user = User::with('gym')->find($id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe', 'status' => 404], 404);
        }

        return response()->json(['user' => $user, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'username' => 'required|unique:users,username',
            'photo' => 'nullable|string',
            'gym_id' => 'nullable|string',
            'age' => 'nullable|digits_between:1,3|numeric',
            'favorite_exercises' => 'nullable|string',
            'goals' => 'nullable|string',
            'hobbies' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error al validar los datos', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'photo' => $request->photo,
            'gym_id' => $request->gym,
            'age' => $request->age,
            'favorite_exercises' => $request->favorite_exercises,
            'goals' => $request->goals,
            'hobbies' => $request->hobbies
        ]);

        return response()->json(['user' => $user, 'status' => 201], 201);
    }

    public function update(Request $request, $id)
    {
        if (Auth::id() !== (int) $id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'username' => 'sometimes|unique:users,username,' . $id,
            'photo' => 'nullable|string',
            'gym_id' => 'nullable|string',
            'age' => 'nullable|digits_between:1,3|numeric',
            'favorite_exercises' => 'nullable|string',
            'goals' => 'nullable|string',
            'hobbies' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->except('password');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['user' => $user], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        if (Auth::id() !== (int) $id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'age' => 'sometimes|digits_between:1,3|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->except('password');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['user' => $user], 200);
    }

    public function destroy($id)
    {
        if (Auth::id() !== (int) $id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $user = User::findOrFail($id);
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente y sesión cerrada'], 200);
    }

    public function uploadPhoto(Request $request)
    {
        $user = $request->user();

        if ($request->hasFile('photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();

            $user->photo = $uploadedFileUrl; 
            $user->save();

            return response()->json(['photo' => $uploadedFileUrl], 200);
        }

        return response()->json(['message' => 'No se subió ninguna imagen'], 400);
    }

    //    public function uploadPhoto(Request $request)
    //    {
    //        $user = $request->user();
    //
    //        if ($request->hasFile('photo')) {
    //            $file = $request->file('photo');
    //
    //            // Guarda la imagen en storage/app/public/uploads
    //            $path = $file->store('uploads', 'public');
    //
    //            // Guarda solo la ruta relativa en DB
    //            $user->photo = $path;
    //            $user->save();
    //
    //            return response()->json(['photo' => $path], 200);
    //        }
    //
    //        return response()->json(['message' => 'No se subió ninguna imagen'], 400);
    //    }
}
