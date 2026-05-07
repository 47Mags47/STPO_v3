<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;

class PaymentType extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__payment_types';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code_id'
    ];
}
