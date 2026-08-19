<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CurrentDivisionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(
            user()->id
        );
        if (user()->hasRole('admin')) {
            return redirect('dashboard');
        }

        // $divisionId = $request->input('division_id');

        // if (!$divisionId) {
        //     return $next($request);
        // }

        // $division = user()
        //     ->divisions()
        //     ->wherePivot('division_id', $divisionId)
        //     ->first();

        // if (!$division) {
        //     abort(404, 'Сотрудник не состоит ни в одной организации.');
        // }

        // session()->put('current_division_id', $division->id);

        return $next($request);
    }
}
