<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index(){
        $users = User::all();

        $data = [
            'users' => $users,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'username' => 'required',
            'photo' => 'required',
            'gym' => 'required',
            'age' => 'required',
            'favorite_exercises' => 'required',
            'hobbies' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'username' => $request->username,
            'photo' => $request->photo,
            'gym' => $request->gym,
            'age' => $request->age,
            'favorite_exercises' => $request->favorite_exercises,
            'goals' => $request->objetivos,
            'hobbies' => $request->hobbies
        ]);

        if (!$users) {
            $data = [
                'message' => 'Error al crear al usuario',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'users' => '$users',
            'status' => 201
        ];

        return response()->json($data, 201);
    }
}
