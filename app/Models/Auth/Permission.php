<?php

namespace App\Models\Auth;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class Permission extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'auth__permissions';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Методы
    ##################################################
    public static function getId(int|string|Permission $permission)
    {
        switch (gettype($permission)) {
            case 'integer':
                return $permission;
                break;

            case 'string':
                return Permission::byCode($permission)->id;
                break;

            case 'object':
                return $permission->id;
                break;

            default:
                return false;
                break;
        }
    }

    ### Связи
    ##################################################
    //
}
