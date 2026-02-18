<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('user')) {
    /**
     * Возвращает текущего пользователя
     * @return User - текущий пользователь
     */
    function user(): User
    {
        $user = Auth::user() ?? new User();

        return $user;
    }
}

if (! function_exists('getRequestPaginate')) {
    function getRequestPaginate(): bool|int
    {
        if (request()->has('paginate')) {
            if (request()->input('paginate') === 'false')
                return false;

            if (((int) request()->input('paginate')) === 0)
                return false;

            return (int) request()->input('paginate');
        }

        return 50;
    }
}
