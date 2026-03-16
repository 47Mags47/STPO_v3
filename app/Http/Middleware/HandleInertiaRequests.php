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
        return [
            ...parent::share($request),
            'currentUser' => Auth::user() !== null
                ? CurrentUserResource::make(Auth::user())
                : null,
            'menu' => collect(
                Modul::whereNull('group_id')->where('in_production', true)
                    ->get()
                    ->map(fn($modul) => MenuItemResource::make($modul)->toArray(request()))
            )->merge(
                ModulGroup::all()
                    ->map(fn($group) => MenuGroupResource::make($group)->toArray(request()))
            )
        ];
    }
}
