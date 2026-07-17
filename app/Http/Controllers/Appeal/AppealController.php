<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\AppealStoreRequest;
use App\Http\Resources\Appeal\ThemGROUPBYGroupResource;
use App\Http\Resources\Appeal\WorkerResource;
use App\Models\Appeal\Appeal;
use App\Models\Appeal\Status;
use App\Models\Appeal\ThemGroup;
use App\Models\Base\User;
use Inertia\Inertia;

class AppealController extends Controller
{
    public function index()
    {
        return Inertia::render('appeal/appeals/index', [
            'appeals' => fn() => Appeal::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/appeals/create', [
            'workers'            => fn() => WorkerResource::make(User::where('id', '!=', user()->id)->get()),
            'them_GROUPBY_group' => fn() => ThemGROUPBYGroupResource::collection(ThemGroup::all()),
        ]);
    }

    public function store(AppealStoreRequest $request)
    {
        Appeal::create(collect($request->validated())->merge([
            'status_id' => Status::byCode('new')->id,
            'sender_id' => user()->id,
            'worker_id' => $request->input('worker'),
            'them_id'   => $request->input('theme'),
            'comment'   => $request->input('comment')
        ])->toArray());

        return redirect()->route('appeal.appeals.index')->with('success', 'Запись успешно создана');
    }

    public function accept(Appeal $appeal) {
        $appeal->update([
            'status_id' => 2,
            'worker_id' => user()->id,
        ]);

        return back();
    }

    public function close(Appeal $appeal) {
        $appeal->update([
            'status_id' => 3,
        ]);

        return back();
    }

    public function reaccept(Appeal $appeal) {
        $appeal->update([
            'status_id' => 4,
            'worker_id' => user()->id,
        ]);

        return back();
    }
}
