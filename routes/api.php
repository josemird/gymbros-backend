<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Laravel\Sanctum\PersonalAccessToken;


// Rutas de autenticación (públicas)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas públicas de usuarios
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);

// Rutas protegidas por Sanctum (token Bearer)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::patch('/user/{id}', [UserController::class, 'updatePartial']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);


    Route::get('/message', [MessageController::class, 'index']);
    Route::post('/message', [MessageController::class, 'store']);
    Route::patch('/message/{id}/read', [MessageController::class, 'markAsRead']);

    Route::get('/like', [LikeController::class, 'index']);
    Route::post('/like', [LikeController::class, 'store']);
    Route::delete('/like/{id}', [LikeController::class, 'destroy']);
});

// debug para inspeccionar el token
Route::get('/debug_token', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'token' => $request->bearerToken(),
    ]);
});

Route::get('/force_profile', function (Request $request) {
    $token = $request->bearerToken();
    $model = PersonalAccessToken::findToken($token);

    if (! $model) {
        return response()->json(['error' => 'Token inválido'], 401);
    }

    $user = $model->tokenable;

    return response()->json([
        'id' => $user->id,
        'email' => $user->email,
        'username' => $user->username,
    ]);
});
