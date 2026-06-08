<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends BaseModel
{
    use HasCode, HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__banks';

    protected $fillable = [
        'code',
        'name'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
