<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class AppealThem extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'appeal__appeal_thems';

    protected $fillable = [
        'code',
        'name',
    ];
}
