<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\AppealStoreRequest;
use App\Http\Resources\Appeal\ThemGROUPBYGroupResource;
use App\Models\Appeal\Appeal;
use App\Models\Appeal\Status;
use App\Models\Appeal\ThemGroup;
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
            'them_GROUPBY_group' => fn() => ThemGROUPBYGroupResource::collection(ThemGroup::all()),
        ]);
    }

    public function store(AppealStoreRequest $request)
    {
        Appeal::create(collect($request->validated())->merge([
            'status_id' => Status::byCode('new')->id,
            'sender_id' => user()->id,
        ])->toArray());

        return redirect()->route('appeal.appeals.index')->with('succes', 'Запись успешно создана');
    }
}
