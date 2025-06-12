<?php

// Descripción: Controlador para manejar la verificación de códigos de usuario en una API RESTful, José Miguel Ramírez Domínguez.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type' => 'required|in:password_reset,register'
        ]);

        $code = random_int(100000, 999999);

        VerificationCode::updateOrCreate(
            ['email' => $request->email, 'type' => $request->type],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        if (app()->environment('production')) {
            Mail::raw("Tu código de verificación es: $code", function ($message) use ($request) {
                $message->to($request->email)->subject('Código de verificación - Gymbros');
            });
        } else {
            logger("Código enviado a {$request->email} (tipo: {$request->type}): $code");
        }

        return response()->json(['message' => 'Código enviado']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8',
            'type' => 'required|in:password_reset,register'
        ]);

        $record = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('type', $request->type)
            ->first();

        if (!$record || $record->expires_at < now()) {
            return response()->json(['message' => 'Código inválido o expirado'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $record->delete();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }
}
