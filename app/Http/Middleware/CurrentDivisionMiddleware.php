<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Administrate\Division;
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
        if (user()->hasRole('system_user'))
            return $next($request);

        $division_id = request()->session()->get('current_division_id');
        if (!$division_id) {
            abort(404, 'Сотрудник не состоит ни в одной организации.');
        }

        $division = Division::find($division_id);
        if (!$division) {
            abort(404, 'Организации не существует.');
        }

        abort_unless(
            user()->divisions()->wherePivot('division_id', $division_id)->exists(),
            403,
            'Сотрудник не состоит в выбранной организации.'
        );

        $request->user()->setRelation('current_division', $division);

        return $next($request);
    }
}
