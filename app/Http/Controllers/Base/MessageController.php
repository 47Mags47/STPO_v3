<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\ChatMessages;
use Illuminate\Http\Request;
use App\Events\Base\MessageReadedEvent;

class MessageController extends Controller
{
    public function readAll(Request $request)
    {
        $messages = ChatMessages::where('chat_id', $request->input('chat_id'))
            ->whereNot('sender_id', $request->input('user_id'))
            ->where('readed', false)
            ->get();

        $messages->each(function ($message) {
            $message->update([
                'readed' => true
            ]);
        });

        broadcast(new MessageReadedEvent(
            $messages,
            $request->input('chat_id'),
        ))->toOthers();

        return response(null);
    }
}
