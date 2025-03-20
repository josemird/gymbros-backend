<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class userController extends Controller
{
    public function index(){
        $users = User::all();

        if ($users->isEmpty()){

            $data = [
                'message' => 'No se encontraron usuarios',
                'status' => 200
            ];

            return response()->json($data,404);
        }

        return response()->json($users, 200);
    }
}
