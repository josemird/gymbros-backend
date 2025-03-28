<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//toDo Crear el controlador y el modelo y ver como implantar el sanctum
//Route::post('/register', [AuthController::class, 'register']);
//Route::post('/login', [AuthController::class, 'login']);
//Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::patch('/user/{id}', [UserController::class, 'updatePartial']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/message', [MessageController::class, 'index']);
    Route::post('/message', [MessageController::class, 'store']);
    Route::patch('/message/{id}/read', [MessageController::class, 'markAsRead']);

    Route::get('/like', [LikeController::class, 'index']);
    Route::post('/like', [LikeController::class, 'store']);
    Route::delete('/like/{id}', [LikeController::class, 'destroy']);

});
