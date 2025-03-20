<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



//Route::get('/users', function (){
//    return 'obteniendo lista de usuarios';
//});

Route::get('/users', [userController::class, 'index']);

Route::get('/users/{id}', function (){
    return 'obteniendo un usuario';
});

Route::post('/users', function (){
    return 'creando usuarios';
});

Route::put('/users/{id}', function (){
    return 'actualizando usuario';
});

Route::delete('/users/{id}', function (){
    return 'eliminando usuario';
});
