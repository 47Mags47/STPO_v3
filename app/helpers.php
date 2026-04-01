<?php

use App\Models\Base\User;
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

if (! function_exists('return_bytes')) {
    function return_bytes(string $val)
    {
        $val = trim($val);
        $number = substr($val, 0, -1);
        $last = strtolower($val[strlen($val) - 1]);

        switch ($last) {
            case 'g':
                $number *= 1024;
            case 'm':
                $number *= 1024;
            case 'k':
                $number *= 1024;
        }
        return $number;
    }
}
