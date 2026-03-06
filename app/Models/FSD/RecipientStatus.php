<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class RecipientStatus extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    public $timestamps = false;

    protected $table = 'fsd__recipient_statuses';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
