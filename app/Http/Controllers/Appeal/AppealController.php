<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\AppealStoreRequest;
use App\Http\Resources\Appeal\AppealResource;
use App\Http\Resources\Appeal\ThemGROUPBYGroupResource;
use App\Models\Appeal\Appeal;
use App\Models\Appeal\Status;
use App\Models\Appeal\Them;
use App\Models\Appeal\ThemGroup;
use App\Models\Base\Chat;
use App\Models\Base\User;
use App\Models\Base\ChatMessage;
use App\Models\Base\Notification;
use App\Events\Appeal\AppealCreated;
use App\Events\Appeal\StatusChanged;
use App\Events\Base\SendNotificationEvent;
use App\Events\Appeal\MessageSent;
use App\Events\Base\SendChatMessageEvent;
use App\Models\Base\NotificationType;
use Inertia\Inertia;

class AppealController extends Controller
{
    public function index()
    {
        return Inertia::render('appeal/appeals/index', [
            'appeals' => fn() => AppealResource::collection(Appeal::filter()->hasPermission()->paginate(25)),
            'senders' => fn() => User::whereIn('id', Appeal::select('sender_id')->distinct()->pluck('sender_id'))->get()->toResourceCollection(),
            'themes' => fn() => Them::all()->toResourceCollection(),
            'statuses' => fn() => Status::all()->toResourceCollection(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/appeals/create', [
            'them_GROUPBY_group' => fn() => ThemGROUPBYGroupResource::collection(ThemGroup::all()),
        ]);
    }

    public function store(AppealStoreRequest $request)
    {
        $chat = Chat::factory()->create();
        $chat->subscribers()->attach(user()->id);

        $appeal = Appeal::create(collect($request->validated())->merge([
            'status_id' => Status::byCode('new')->id,
            'sender_id' => user()->id,
            'them_id' => $request->input('theme'),
            'chat_id' => $chat->id,
            'comment' => $request->input('comment')
        ])->toArray());

        broadcast(new AppealCreated($appeal))->toOthers();

        $message = ChatMessage::factory()->create([
            'message' => 'Заявка создана пользователем ' . user()->full_name,
            'sender_id' => null,
            'is_system' => true,
            'chat_id' => $chat->id,
        ]);

        broadcast(new MessageSent(
            $message,
            $appeal->id,
        ));

        return redirect()->route('appeal.appeals.show', ['appeal' => $appeal->id])->with('success', 'Запись успешно создана');
    }

    public function show(Appeal $appeal)
    {
        return Inertia::render('appeal/messages/index', [
            'appeal' => $appeal->toResource(),
            'messages' => Inertia::scroll(fn() => $appeal->chat->messages()->orderBy('created_at', 'desc')->paginate(15)->toResourceCollection())
        ]);
    }

    public function accept(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 2,
            'worker_id' => user()->id,
        ]);

        $appeal->chat->subscribers()->attach(user()->id);

        broadcast(new StatusChanged($appeal))->toOthers();

        $message = ChatMessage::factory()->create([
            'message' => 'Заявка принята пользователем ' . user()->full_name,
            'sender_id' => null,
            'is_system' => true,
            'chat_id' => $appeal->chat_id,
        ]);

        broadcast(new MessageSent(
            $message,
            $appeal->id,
        ));

        $appeal->chat->subscribers->each(function ($subscriber) use ($message) {
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

        return redirect()->route('appeal.appeals.show', ['appeal' => $appeal->id]);
    }

    public function close(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 3,
        ]);

        broadcast(new StatusChanged($appeal))->toOthers();

        $message = ChatMessage::factory()->create([
            'message' => 'Заявка закрыта пользователем ' . user()->full_name,
            'sender_id' => null,
            'is_system' => true,
            'chat_id' => $appeal->chat->id,
        ]);

        broadcast(new MessageSent(
            $message,
            $appeal->id,
        ));

        $appeal->chat->subscribers->each(function ($subscriber) use ($message) {
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

        return redirect()->route('appeal.appeals.index');
    }

    public function reaccept(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 4
        ]);

        if($appeal->chat->subscribers()->where('user_id', user()->id)->count() === 0)
            $appeal->chat->subscribers()->attach(user()->id);

        broadcast(new StatusChanged($appeal))->toOthers();

        $message = ChatMessage::factory()->create([
            'message' => 'Заявка возобновлена пользователем ' . user()->full_name,
            'sender_id' => null,
            'is_system' => true,
            'chat_id' => $appeal->chat_id,
        ]);

        broadcast(new SendChatMessageEvent($message));

        $appeal->chat->subscribers->each(function ($subscriber) use ($message) {
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

        return redirect()->route('appeal.appeals.show', ['appeal' => $appeal->id]);
    }
}
