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
        if(user()->hasRole('system_user'))
            return $next($request);

        $division_id = request()->session()->get('current_division_id');

        if ($division_id === null) {
            // Если в сессии нет id организации, значит сессия была начата без указания организации
            // редиректим человека на страницу выбора организации
            return redirect()->route('select-division.index');
        }

        $division = Division::whereKey($division_id)->first();

        if ($division === null) {
            // Если в сессии есть ключ организации, но такой организации не существует
            // возможно, что человек подменил сессию, или организация была удалена
            // сбрасываем current_division_id и редиректим человека на страницу выбора организации
            session()->forget('current_division_id');
            return redirect()->route('select-division.index');
        }

        if(!user()->divisions()->wherePivot('division_id', $division_id)->exists()){
            // Скорее всего человек пытаеться подменить сессию
            // сбрасываем current_division_id и редиректим человека на страницу выбора организации
            session()->forget('current_division_id');
            return redirect()->route('select-division.index');
        }

        return $next($request);
    }
}
