<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;

class TransitCategory extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__transit_categories';

    protected $fillable = [
        'name',
        'wp_category_id'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
