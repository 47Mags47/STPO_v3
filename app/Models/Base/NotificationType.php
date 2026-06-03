<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class NotificationType extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'base__notifications_types';

    protected $fillable = [
        'code',
        'name',
        'status_id',
        'status'
    ];

    public $timestamps = false;

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
