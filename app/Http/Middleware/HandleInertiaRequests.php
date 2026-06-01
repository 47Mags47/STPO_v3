<?php

namespace App\Http\Middleware;

use App\Http\Resources\CurrentUserResource;
use App\Http\Resources\MenuGroupResource;
use App\Http\Resources\MenuItemResource;
use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $shared = parent::share($request);

        // Flash
        $shared['flash'] = [];
        if ($request->session()->has('success'))
            $shared['flash']['success'] = [$request->session()->get('success')];

        if ($request->session()->has('error'))
            $shared['flash']['error'] = [$request->session()->get('error')];

        if ($request->session()->has('info'))
            $shared['flash']['info'] = [$request->session()->get('info')];

        if ($request->session()->has('warning'))
            $shared['flash']['warning'] = [$request->session()->get('warning')];

        if ($request->session()->has('loading'))
            $shared['flash']['loading'] = [$request->session()->get('loading')];


        // User
        $shared['current_user'] = Auth::user() !== null
            ? CurrentUserResource::make(Auth::user())
            : null;

        // Menu
        $shared['menu'] = collect(
            Modul::whereNull('group_id')->where('in_production', true)
                ->get()
                ->map(fn($modul) => MenuItemResource::make($modul)->toArray(request()))
        )->merge(
            ModulGroup::all()
                ->map(fn($group) => MenuGroupResource::make($group)->toArray(request()))
        );


        return $shared;
    }
}
