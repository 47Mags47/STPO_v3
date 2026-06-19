<?php

namespace App\Models;

use App\Classes\BaseModel;

class Division extends BaseModel
{
    //

    ### Настройки
    ##################################################
    protected $table = 'main_divisions';

    protected $fillable = [
        'id',
        'name',
        'city_id'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
