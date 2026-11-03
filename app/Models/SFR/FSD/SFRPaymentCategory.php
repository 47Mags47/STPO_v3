<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SFRPaymentCategory extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__sfr_payment_categories';

    protected $fillable = [
        'pay_number',
        'name',
    ];
}
