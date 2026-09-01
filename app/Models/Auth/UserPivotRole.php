<?php

namespace App\Models\Auth;

use App\Classes\BaseModel;

class UserPivotRole extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'auth__users_pivot_roles';

    protected $fillable = [
        'user_id',
        'role_id',
        'division_id',
        'modul_id',
    ];
}
