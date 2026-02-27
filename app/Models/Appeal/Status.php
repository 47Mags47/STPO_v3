<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class Status extends BaseModel
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
