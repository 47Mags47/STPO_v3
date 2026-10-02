<?php

namespace App\Http\Controllers\Base;

use App\Events\Base\SendChatMessageEvent;
use App\Events\Base\SendNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Base\ChatMessageStoreRequest;
use App\Models\Base\Chat;
use App\Models\Base\ChatMessage;
use App\Models\Base\ChatMessageAttachment;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\UploadFile;

class ChatMessageController extends Controller
{
    public function index(Chat $chat)
    {
        return $chat->messages()->orderBy('created_at', 'desc')->paginate(25)->toResourceCollection();
    }

    public function store(ChatMessageStoreRequest $request, Chat $chat)
    {
        $message = ChatMessage::factory()->create([
            'message'       => $request->message,
            'sender_id'     => user()->id,
            'chat_id'       => $chat->id,
        ]);

        if ($request->has('files')){
            foreach ($request->input('files') as $file_id) {
                $file = UploadFile::moveToModel($file_id, ChatMessageAttachment::class, [
                    'message_id' => $message->id,
                ]);

                $file->setStatus('ok');
            }
        }

        broadcast(new SendChatMessageEvent($message))->toOthers();

        $chat->subscribers()->where('user_id', '<>', user()->id)->get()->each(function ($subscriber) use ($message) {
            $notification = Notification::factory()->create([
                'recipient_id' => $subscriber->id,
                'message' => $message->message,

                'type_id' => NotificationType::byCode('new_message'),
                'context' => [
                    'chat_id' => $message->chat_id,
                ]
            ]);

            broadcast(new SendNotificationEvent($notification));
        });

        return $message->toResource();
    }
}
