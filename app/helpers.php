<?php

use App\Classes\FileModel;
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

        return 25;
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

if (! function_exists('PATTERNS')) {
    function PATTERNS(string $pattern)
    {
        return [
            'CSV_SEPARATOR' => "[.,; ]",
            'LAST_NAME'     => "[а-яА-ЯёЁ -]{0,255}",
            'FIRST_NAME'    => "[а-яА-ЯёЁ -]{0,255}",
            'MIDDLE_NAME'   => "[а-яА-ЯёЁ -]{0,255}",
            'DOT_DATE'      => "[0-9]{2}\.[0-9]{2}\.[0-9]{4}",
            'FLOAT'         => "[0-9]{1,6}\.[0-9]{2}",
            'SNILS'         => "[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}",
            'TIMESTAMP'     => "[0-9]*",
            'ACCOUNT'       => "[0-9]{20}",
            'RU_TEXT'       => "[а-яА-ЯёЁ -]{0,255}",
        ][$pattern] ?? '//';
    }
}

if (! function_exists('getCSVSeparator')) {
    function getCSVSeparator(string $line)
    {
        $line = trim($line);

        if (count(str_getcsv($line, ';')) > 1)
            return ';';

        if (count(str_getcsv($line, '.')) > 1)
            return '.';

        if (count(str_getcsv($line, ',')) > 1)
            return ',';

        return false;
    }
}

if (! function_exists('clearString')) {
    function clearString(string $string)
    {
        return str_replace(["\r\n", "\r", "\n"], '', trim($string));
    }
}

if (! function_exists('waitDisabledFile')) {
    function waitDisabledFile(FileModel $file) {
        if($file->file->is_disabled){
            sleep(1);
            waitDisabledFile($file->fresh());
        }
    }
}
