<?php

// Descripción: Controlador para manejar los mensajes entre usuarios en una API RESTful, José Miguel Ramírez Domínguez.

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
        $messages = Message::with(['sender', 'receiver'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'asc')
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
            'content' => (string) $request->input('content'),
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

    public function getUnreadMessages()
    {
        $userId = Auth::id();

        $unread = Message::where('receiver_id', $userId)
            ->where('read', false)
            ->get();

        return response()->json(['messages' => $unread]);
    }

    public function getUnreadCount()
    {
        $userId = Auth::id();

        $counts = Message::where('receiver_id', $userId)
            ->where('read', false)
            ->selectRaw('sender_id, COUNT(*) as count')
            ->groupBy('sender_id')
            ->get();

        return response()->json(['counts' => $counts]);
    }

}
