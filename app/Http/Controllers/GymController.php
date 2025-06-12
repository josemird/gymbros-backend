<?php

//Descripción: Controlador para obtener la lista de gimnasios disponibles en la API RESTful, José Miguel Ramírez Domínguez.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;

class GymController extends Controller
{
    public function index()
    {
        $gyms = Gym::all();
        return response()->json(['gyms' => $gyms], 200);
    }
}
