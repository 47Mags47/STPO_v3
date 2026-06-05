<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__payments';

    protected $fillable = [
        'code',
        'name',
        'kbk'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
