<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\MessageStoreRequest;
use App\Http\Resources\Base\ChatMessagesResource;
use App\Models\Appeal\Appeal;
use App\Models\Base\ChatMessages;
use App\Models\Base\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Events\Appeal\MessageSent;

class MessageController extends Controller
{
    public function index(Appeal $appeal)
    {
        return Inertia::render('appeal/messages/index', [
            'appeal' => $appeal->toResource(),
            'messages' => Inertia::scroll(fn() => ChatMessagesResource::collection($appeal->chat->messages()
                ->orderBy('id', 'desc')
                ->cursorPaginate(25))),
        ]);
    }

    public function store(MessageStoreRequest $request, Appeal $appeal)
    {
        if ($request->hasFile('file')) {
            $upload_file = $request->file('file');

            $message = File::createChildren(ChatMessages::class, [
                'name' => $upload_file->hashName(),
                'path' => ChatMessages::$storage_file_path . '/' . $appeal->chat_id,
                'origin_name' => $upload_file->getClientOriginalName(),

                'message'       => $request->message,
                'context'       => [
                    'is_image'  => str_starts_with($upload_file->getMimeType(), 'image/'),
                ],
                'sender_id'     => user()->id,
                'chat_id'       => $appeal->chat_id,
            ]);

            $message->file->write($upload_file->getContent());

        } else {
            $message = ChatMessages::create([
                'message'       => $request->message,
                'sender_id'     => user()->id,
                'chat_id'       => $appeal->chat_id,
            ]);
        }


        broadcast(new MessageSent(
            $message,
            $appeal->id
        ))->toOthers();

        return redirect()->route('appeal.messages.index', ['appeal' => $appeal]);
    }

    public function update(Request $request, Appeal $appeal, ChatMessages $message)
    {
        $message->update($request->validated());

        return redirect()
            ->route('appeal.messages.index', ['appeal' => $appeal])
            ->with('success', 'Запись успешно обновлена');
    }

    public function destroy(ChatMessages $message)
    {
        $message->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
