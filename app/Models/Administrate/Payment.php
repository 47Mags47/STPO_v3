<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__payments';

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
