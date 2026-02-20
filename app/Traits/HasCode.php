<?php

namespace App\Traits;

trait HasCode
{
    public static function byCode(string $code){
        return self::where('code', $code)->first();
    }
}
