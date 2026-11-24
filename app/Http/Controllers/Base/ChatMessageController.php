<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\ChatMessageStoreRequest;
use App\Models\Base\Chat;
use App\Models\Base\ChatMessage;
use App\Models\Base\ChatMessageAttachment;
use App\Models\Base\UploadFile;

class ChatMessageController extends Controller
{
    public function index(Chat $chat)
    {
        if (user()->cannot('view', $chat))
            return abort(403);

        return $chat->messages()->orderBy('created_at', 'desc')->paginate(25)->toResourceCollection();
    }

    public function store(ChatMessageStoreRequest $request, Chat $chat)
    {
        if (user()->cannot('view', $chat))
            return abort(403);

        $message = ChatMessage::factory()->create([
            'message'   => $request->has('files') ? 'Файл(ы)' : $request->input('message'),
            'sender_id' => user()->id,
            'chat_id'   => $chat->id,
        ]);

        if ($request->has('files')) {
            foreach ($request->input('files') as $file_id) {
                UploadFile::moveToModel($file_id, ChatMessageAttachment::class, [
                    'message_id' => $message->id,
                ]);
            }
        }

        return $message->toResource();
    }
}
