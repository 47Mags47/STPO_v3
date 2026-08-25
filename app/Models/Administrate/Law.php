<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Law extends BaseModel
{
    /** @use HasFactory<\Database\Factories\Administrate\LawFactory> */
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__laws';

    protected $fillable = [
        'number',
        'name'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
