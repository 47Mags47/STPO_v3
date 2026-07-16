<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;

class SFRPaymentCategory extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__sfr_payment_categories';

    protected $fillable = [
        'pay_number',
        'name',
    ];
}
