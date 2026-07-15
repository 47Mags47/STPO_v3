<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\MessageStoreRequest;
use App\Http\Resources\Appeal\MessageResource;
use App\Models\Appeal\Appeal;
use App\Models\Appeal\Message;
use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Events\Appeal\MessageSent;

class MessageController extends Controller
{
    public function index(Appeal $appeal)
    {
        return Inertia::render('appeal/messages/index', [
            'appeal' => $appeal->toResource(),
            'messages' => Inertia::scroll(fn() => MessageResource::collection($appeal->messages()
                ->orderBy('id', 'desc')
                ->cursorPaginate(25))),
        ]);
    }

    public function store(MessageStoreRequest $request, Appeal $appeal)
    {
        $message = Message::create([
            'message'       => $request->message,
            'sender_id'     => user()->id,
            'appeal_id'     => $appeal->id,
        ]);

        // DEV Переделать в отдельную модель
        if ($request->hasFile('file')) {
            $file = File::factory()->create([
                'disk' => 'appeals',
                'path' => 'messages/' . $appeal->id,
                'origin_name' => $request->file('file')->getBasename(),
            ]);

            $request->file('file')->storeAs($file->path, $file->name, $file->disk);

            $message->file_id = $file->id;
        }

        $message->save();

        broadcast(new MessageSent(
            $message,
            $appeal->id
        ))->toOthers();

        return redirect()
            ->route('appeal.messages.index', ['appeal' => $appeal]);
    }

    public function show(Appeal $appeal, Message $message)
    {
        if ($message->file_id !== null)
            return response()->file($message->getFullPath());

        return abort(404);
    }

    public function update(Request $request, Appeal $appeal, Message $message)
    {
        $message->update($request->validated());

        return redirect()
            ->route('appeal.messages.index', ['appeal' => $appeal])
            ->with('success', 'Запись успешно обновлена');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
