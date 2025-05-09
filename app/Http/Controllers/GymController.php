<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;

class GymController extends Controller {
    public function index() {
        return response()->json(['gyms' => Gym::all()]);
    }
}
