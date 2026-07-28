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
use App\Models\Base\ChatSubscribers;
use App\Models\Base\User;
use App\Events\Appeal\AppealCreated;
use App\Events\Appeal\StatusChanged;
use Inertia\Inertia;
use Illuminate\Http\Request;


class AppealController extends Controller
{
    public function index(Request $request)
    {
        // dump($request->input('filters'));
        return Inertia::render('appeal/appeals/index', [
            'appeals'   => fn() => AppealResource::collection(Appeal::filter()->hasPermission()->get()),
            'senders'   => fn() => User::whereIn('id', Appeal::select('sender_id')->distinct()->pluck('sender_id'))->get()->toResourceCollection(),
            'themes'    => fn() => Them::all()->toResourceCollection(),
            'statuses'  => fn() => Status::all()->toResourceCollection(),
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
        $chat_id = Chat::create()->id;

        $appeal = Appeal::create(collect($request->validated())->merge([
            'status_id' => Status::byCode('new')->id,
            'sender_id' => user()->id,
            'them_id'   => $request->input('theme'),
            'chat_id'   => $chat_id,
            'comment'   => $request->input('comment')
        ])->toArray());

        ChatSubscribers::create([
            'chat_id'   => $chat_id,
            'user_id'   => user()->id
        ]);

        broadcast(new AppealCreated($appeal))->toOthers();

        return redirect()->route('appeal.appeals.index')->with('success', 'Запись успешно создана');
    }

    public function accept(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 2,
            'worker_id' => user()->id,
        ]);

        ChatSubscribers::updateOrCreate([
            'chat_id' => $appeal->chat_id,
            'user_id' => user()->id
        ]);

        broadcast(new StatusChanged($appeal))->toOthers();

        return back();
    }

    public function close(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 3,
        ]);

        broadcast(new StatusChanged($appeal))->toOthers();

        return back();
    }

    public function reaccept(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 4
        ]);

        ChatSubscribers::updateOrCreate([
            'chat_id' => $appeal->chat_id,
            'user_id' => user()->id
        ]);

        broadcast(new StatusChanged($appeal))->toOthers();

        return back();
    }
}
