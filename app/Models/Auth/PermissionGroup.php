<?php

namespace App\Models\Auth;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class PermissionGroup extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'auth__permission_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
