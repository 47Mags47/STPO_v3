<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;

class FinancingType extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'administrate__financing_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sfr_fsd_code',
        'asp_name',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
