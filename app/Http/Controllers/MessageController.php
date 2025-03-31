<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['messages' => $messages], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'read' => false,
            'sent_at' => now(),
        ]);

        return response()->json(['message' => $message], 201);
    }

    public function markAsRead($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'El mensaje no existe'], 404);
        }

        if ($message->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $message->update(['read' => true]);

        return response()->json(['message' => 'Mensaje marcado como leído'], 200);
    }
}
