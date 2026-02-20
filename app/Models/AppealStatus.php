<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class AppealStatus extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'appeal__statuses';

    protected $fillable = [
        'code',
        'name',
    ];
}
